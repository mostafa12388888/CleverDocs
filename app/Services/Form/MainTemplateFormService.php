<?php

namespace App\Services\Form;

use App\Http\Filters\Filter;
use App\Repository\Form\MainTemplateFormRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class MainTemplateFormService extends MainService
{

    /**
     * @var MainTemplateFormRepository
     */
    protected MainRepository $repository;

    /**
     * @param MainTemplateFormRepository $repository
     */
    public function __construct(MainTemplateFormRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function allWithLastVersion(int $page, int $perPage,?Filter $filter = null): mixed
    {
        return $this->repository->allWithLastVersion($page, $perPage,$filter);
    }

    /**
     * getDataExport
     *
     * @param  mixed $filter
     * @return void
     */
    public function getDataExport(?Filter $filter = null)
    {
        return $this->repository->allWithLastVersion(1,2,$filter, false);
    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookup(?Filter $filter = null):mixed
    {
        $moduleGroup= $this->repository->lookup($filter)->groupBy("modules");
        return $this->_mapModuleGroups($moduleGroup);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage,?Filter $filter = null): mixed
    {
        return $this->repository->lookupPaginate($page, $perPage,$filter);
    }

    function _mapModuleGroups($data)
    {
        $convertedData = [];
        foreach ($data as $module => $forms) {
            $convertedData[] = (object)[
                "module" => json_decode($module),
                "forms" => $forms
            ];
        }
        return $convertedData;
    }
    /**
     * summary
     *
     * @return mixed
     */
    public function summary():mixed
    {
        return $this->repository->summary();
    }


    public function allLastFormVersionInputs(int $id):mixed
    {
        return $this->repository->allLastFormVersionInputs($id);
    }


}

