<?php

namespace App\Services\Form;

use App\Http\Filters\Filter;
use App\Repository\Form\InputTypeRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use Illuminate\Support\Str;


class InputTypeService extends MainService
{

    /**
     * @var InputTypeRepository
     */
    protected MainRepository $repository;

    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function __construct(InputTypeRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    /**
     * index
     *
     * @param  mixed $filter
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function index(?Filter $filter=Null,int $page, int $perPage): mixed
    {
        return $this->repository->index($filter,$page, $perPage);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $filter
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function lookupPaginate(?Filter $filter=Null,int $page, int $perPage): mixed
    {
        return $this->repository->lookupPaginate($filter,$page, $perPage);
    }
      /**
     * getDataExport
     *
     * @param  mixed $filter
     * @return void
     */
    public function getDataExport(?Filter $filter = null)
    {
        return $this->repository->index( $filter,1,2, false);
    }
    /**
     * categories
     *
     * @param  mixed $filter
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function categories(?Filter $filter=Null): mixed
    {
        $inputTypesGrouped = $this->repository->categories($filter)->groupBy("category");
        return $this->_mapInputsCategoryGroups($inputTypesGrouped);
    }
    /**
     * _dataSet
     *
     * @param  mixed $data
     * @return array
     */
    function _mapInputsCategoryGroups($data): array
    {
        $convertedData = [];
        foreach ($data as $categoryName => $inputs) {
            $convertedData[] = (object)[
                "category" => $categoryName,
                "inputs" => $inputs
            ];
        }
        return $convertedData;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Throwable
     */
    public function store(array $data): mixed
    {
        return $this->add([
                'type' => $data['type'],
                'category' => $data["category"],
                'title' => $data["title"],
                'custom_option_list_id' =>$data["customListOptionsId"] ?? null,
                "options_type" => $data["optionsType"] ?? null,
                "entity" => $data["entity"]?? null ,
                "created_by" => auth()->user()->id,
                "key"=>Str::uuid(),
            ]);
    }

    public function update(int $id, array $data): mixed
    {
        $inputType=$this->findOrFail($id);
        return $this->repository->update($id, [
            'type' => $data['type'],
            'title' => $data["title"],
            'custom_option_list_id' => array_key_exists('customListOptionsId', $data)? $data['customListOptionsId']: $inputType->custom_option_list_id,
            "updated_by" => auth()->user()->id,
        ]);
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return mixed
     */
    public function deleteInputType(int $id): mixed
    {
        $inputType=$this->find($id);
        if(!$inputType) return false;
        $this->repository->update($id, ["deleted_by" => auth()->user()->id]);
        return $this->delete([$id]);
    }
     /**
     * bulkDelete
     *
     * @param  mixed $wbsId
     * @return mixed
     */
    public function bulkDelete(array $inputType): mixed
    {
        $this->repository->updateWhereIn("id",$inputType["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        return $this->delete($inputType["ids"]);
    }

    //TODO:this Business Validation
    public function _validateDelete(): void
    {
    }
}
