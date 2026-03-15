<?php

namespace App\Services\Form\CustomOption;

use App\Exceptions\Form\CustomOption\CanDeleteCustomItemsException;
use App\Http\Filters\Filter;
use App\Repository\Form\CustomOption\InputOptionRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use App\Exceptions\Form\InputType\CanDeleteIsDefaultInputException;


class InputOptionServices extends MainService
{

    /**
     * @var InputOptionRepository
     */
    protected MainRepository $repository;

    public function __construct(InputOptionRepository $repository)
    {
        $this->repository = $repository;
        Parent::__construct($repository);
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param Filter|null $filter
     * @return mixed
     */
    public function list(int $page, int $perPage, ?Filter $filter=null): mixed
    {
        return $this->repository->list($page, $perPage, $filter);
    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookup(?Filter $filter=null): mixed
    {
        return $this->repository->lookup($filter);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage, ?Filter $filter=null): mixed
    {
        return $this->repository->lookupPaginate($page, $perPage, $filter);
    }

    /**
     * store
     *
     * @param mixed $data
     * @return mixed
     * @throws \Throwable
     */
    public function store(array $data): mixed
    {

        $this->_oneItemIsDefault($data);
        return $this->add([
            "title" => $data["name"],
             "is_active" => $data["isActive"],
             "is_default_list" => $data["isDefaultList"]??false,
            "custom_option_list_id" => $data["listId"],
            "created_by"=>auth()->id(),
        ]);
    }
    /**
     * update
     *
     * @param  mixed $inputOptionId
     * @param  mixed $data
     * @return mixed
     */
    public function update(int $inputOptionId, array $data): mixed
    {
        $inputOption = $this->findOrFail($inputOptionId);
        $this->_oneItemIsDefault($data);
        return $this->repository->update($inputOption->id, [
            "title" => $data["name"],
             "is_active" => $data["isActive"],
             "is_default_list" => $data["isDefaultList"]?$data["isDefaultList"]:$inputOption->is_default_list,
            "custom_option_list_id" => $data["listId"],
            "updated_by"=>auth()->id(),
        ]);
    }

    /**
     * _oneItemIsDefault
     *
     * @param  mixed $data
     * @return void
     */
    public function _oneItemIsDefault( array $data):void
    {
        if($data["isDefaultList"]){
            $this->updateManyWhere([
                "custom_option_list_id" => $data["listId"],
            ],[
                "is_default_list" => false
            ]);
        }
    }
    /**
     * findData
     *
     * @param  mixed $inputOptionId
     * @return mixed
     */
    public function findData(int $inputOptionId):mixed
    {
        return $this->firstOrFailBy(["id"=>$inputOptionId]);
    }

    /**
     * deleteInputOptionList
     *
     * @param mixed $id
     * @return void
     * @throws \Throwable
     */
    public function deleteInputOptionList(int $id): void
    {

        $option=$this->find($id);
        if (!$option) return;
        $this->_validateDelete($option);
        parent::update($id,[
            "deleted_by"=>auth()->id(),
        ]);
        $this->delete([$id]);
    }
     /**
     * bulkDelete
     *
     * @param  mixed $wbsId
     * @return mixed
     */
    public function bulkDelete(array $inputOption): mixed
    {
        foreach($inputOption["ids"] as $id){
            $item=$this->find($id);
            $this->_validateDelete($item);
        }
        $this->repository->updateWhereIn("id",$inputOption["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        return $this->delete($inputOption["ids"]);

    }
 public function _validateDelete(object $inputOption): void
{
    if ($inputOption->is_default) {
        throw new CanDeleteIsDefaultInputException();
    }

    $locale = app()->getLocale();

    $values = $inputOption->customOptionList?->inputTypeSubject
        ->flatMap(function ($inputType) {
            return $inputType->templateInput?->submissionValue ?? collect();
        })
        ->filter(function ($submission) {
            return !empty($submission->form_submission_id);
        })
        ->unique(fn ($item) => $item['form_submission_id'])
        ->pluck('value')
        ->map(function ($value) use ($locale) {
            $decoded = is_string($value) ? json_decode($value, true) : $value;
            if (is_array($decoded)) {
                $text = $decoded[$locale] ?? reset($decoded);
                return is_array($text) ? implode(', ', $text) : $text;
            }
            return $decoded ?: null;
        })
        ->filter() // remove nulls or empty values
        ->values()
        ->toArray();

    if (!empty($values)) {
        throw new CanDeleteCustomItemsException($values);
    }
}

}
