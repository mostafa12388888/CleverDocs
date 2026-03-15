<?php

namespace App\Services\Form\CustomOption;

use App\Exceptions\Form\CustomOption\CanDeleteCustomOptionListException;
use App\Exceptions\Form\InputType\CanDeleteIsDefaultInputException;
use App\Http\Filters\Filter;
use App\Repository\Form\CustomOption\CustomOptionListRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use Illuminate\Support\Str;

class CustomOptionListServices extends MainService
{


    /**
     * @var CustomOptionListRepository
     */
    protected MainRepository $repository;


    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function __construct(CustomOptionListRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    /**
     * index
     *
     * @param  mixed $listId
     * @param  mixed $listKey
     * @param  mixed $page
     * @param  mixed $perPage
     * @return void
     */
    public function index(?Filter $filter, int $page, int $perPage)
    {
        return $this->repository->index($filter, $page, $perPage);
    }
    /**
     * getDataExport
     *
     * @param  mixed $filter
     * @return void
     */
    public function getDataExport(?Filter $filter = null)
    {
        return $this->repository->index($filter,1,2, false);
    }
     /**
     * lookup
     *
     * @param  mixed $filter
     * @param  mixed $page
     * @param  mixed $perPage
     * @return void
     */
    public function lookup(?Filter $filter)
    {
        return $this->repository->lookup($filter);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $filter
     * @param  mixed $page
     * @param  mixed $perPage
     * @return void
     */
    public function lookupPaginate(?Filter $filter, int $page, int $perPage)
    {
        return $this->repository->lookupPaginate($filter, $page, $perPage);
    }
    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {

        return $this->add([
            "title" => $data["name"],
            "is_active" => $data["isActive"],
            "key" => Str::uuid(),
            "created_by" => auth()->user()->id,
        ]);

    }
    /**
     * update
     *
     * @param  mixed $customListId
     * @param  mixed $data
     * @return mixed
     */
    public function update(int $customListId, array $data): mixed
    {
        $customList = $this->findOrFail($customListId);
        return $this->repository->update($customList->id, [
            "title" => $data["name"],
            "is_active" => $data["isActive"],
            "updated_by" => auth()->user()->id,
        ]);
    }
    /**
     * deleteCustomOptionList
     *
     * @param  mixed $id
     * @return mixed
     */
    public function deleteCustomOptionList(int $id): mixed
    {
        $customList= $this->find($id);
        if(!$customList)return false;
        $this->_validateDelete($customList);
        $this->repository->update($id, ['deleted_by' => auth()->user()->id]);
        return $this->delete([$id]);
    }
    /**
     * bulkDelete
     *
     * @param  mixed $wbsId
     * @return mixed
     */
    public function bulkDelete(array $customList): mixed
    {
          foreach($customList["ids"] as $id){
            $custom=$this->find($id);
            $this->_validateDelete($custom);
        }
        $this->repository->updateWhereIn("id",$customList["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        return $this->delete($customList["ids"]);

    }
    /**
     * _validateDelete
     *
     * @param  mixed $customList
     * @return void
     */
public function _validateDelete(object $customList): void
{
    if ($customList->is_default) {
        throw new CanDeleteIsDefaultInputException();
    }
    $locale = app()->getLocale();
    $values = $customList->inputTypeSubject
        ->flatMap(function ($inputType) {
            return $inputType->templateInput?->submissionValue ?? collect();
        })
        ->filter(function ($submission) {
            return !empty($submission->form_submission_id);
        })->unique(fn ($item) => $item['form_submission_id'])
        ->pluck('value')
        ->map(function ($value) use ($locale) {
            $decoded = is_string($value) ? json_decode($value, true) : $value;
            if (is_array($decoded)) {
                $text = $decoded[$locale] ?? reset($decoded);
                return is_array($text) ? implode(', ', $text) : $text;
            }
            return $decoded ?: null;
        })
        ->values()
        ->toArray();

    if (!empty($values)) {
        throw new CanDeleteCustomOptionListException($values);
    }
}




}
