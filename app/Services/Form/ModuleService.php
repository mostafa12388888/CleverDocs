<?php

namespace App\Services\Form;

use App\Exceptions\Form\CanDeleteModuleAssignFormException;
use App\Http\Filters\Filter;
use App\Repository\Form\ModuleRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class ModuleService extends MainService
{

    /**
     * @var ModuleRepository
     */
    protected MainRepository $repository;
    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function  __construct(ModuleRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * storeModule
     *
     * @param  mixed $data
     * @return mixed
     */
    public function storeModule(array $data): mixed
    {
        return  $this->add([
            'name' => $data['name'],

            "order" => $data['order'] ?? $this->max('order', []) + 1,
            "created_by"=>auth()->user()->id,
        ]);
    }

    /**
     * showAll
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function showAll(int $page, int $perPage,?Filter $filter = null): mixed
    {
        return $this->repository->index($page, $perPage,$filter);
    }
      /**
     * getDataExport
     *
     * @param  mixed $filter
     * @return void
     */
    public function getDataExport(?Filter $filter = null)
    {
        return $this->repository->index(1, 2, $filter, false);
    }
    /**
     * showLookupData
     *
     * @return mixed
     */
    public function showLookupData(?Filter $filter = null): mixed
    {
        return $this->repository->showLookupData($filter);
    }

    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage,?Filter $filter=null): mixed
    {
        return  $this->repository->lookupPaginate($page, $perPage, $filter);
    }



    public function mainFormWithLastVersions(int $projectId, ?Filter $filter=null){
        $rows = $this->repository->mainFormWithLastVersions($projectId,$filter);

            $grouped = $rows->groupBy('module_id')->map(function ($forms) {
                $moduleRow = $forms->first();

                $formsCollection = $forms->map(function ($form) {
                    return (object) [
                        'mainFormId'    => $form->main_form_id,
                        'formVersionId' => $form->form_version_id,
                        'name'          => $form->form_name ? json_decode($form->form_name, true) : null,
                        'version'       => $form->form_version,
                    ];
                })->values();

                return (object) [
                    'id'    => $moduleRow->module_id,
                    'name'  => $moduleRow->module_name ? json_decode($moduleRow->module_name, true) : null,
                    'forms' => $formsCollection,
                ];
            })->values();

        return collect($grouped);
    }
    /**
     * updateModule
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return void
     */
    public function updateModule(array $data, int $id)
    {
        $modulate = $this->findOrFail($id);
        return $this->repository->update($modulate->id, [
            "name" => $data['name'],
            "order" => $data['order'],
            "updated_by"=>auth()->user()->id,
        ]);
    }
    /**
     * updateOrderModule
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return void
     */
    public function updateOrderModule(array $data): mixed
    {
        $moduleData = [];
        foreach ($data['moduleData'] as $index=>$value)
            $moduleData[$index] = $this->update($value["moduleId"],
            [
                "order" => $value['order'],
                "updated_by"=>auth()->user()->id,
            ]);
        return $moduleData;
    }

    /**
     * deleteModule
     *
     * @param mixed $id
     * @return void
     * @throws \Throwable
     */
    public function deleteModule(int $id): void
    {
        $module=$this->find($id);
        if(!$module) return;
        $this->_validateDelete($module);
        $this->update($id,["deleted_by"=>auth()->user()?->id]);
        $this->delete([$id]);

    }
    /**
     * bulkDelete
     *
     * @param  mixed $wbsId
     * @return mixed
     */
    public function bulkDelete(array $module): mixed
    {
        foreach($module["ids"] as $id){
        $mod=$this->find($id);
        $this->_validateDelete($mod);
        }
        $this->repository->updateWhereIn("id",$module["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        return $this->delete($module["ids"]);
    }

    /**
     * _validateDelete
     *
     * @param  mixed $id
     * @return void
     */
public function _validateDelete(object $module): void
{
    if ($module->mainTemplateForms()->exists()) {
        $locale = app()->getLocale();

        $formNames = $module->mainTemplateForms()
            ->pluck('name')
            ->map(function ($name) use ($locale) {
                $decoded = is_string($name) ? json_decode($name, true) : $name;
                return $decoded[$locale] ?? reset($decoded);
            })
            ->toArray();

        throw new CanDeleteModuleAssignFormException($formNames);
    }
}

}
