<?php

namespace App\Services\Workflow;

use App\Http\Filters\Filter;
use App\Http\Filters\Form\MainTemplateFormFilter;
use App\Repository\MainRepository;
use App\Repository\Workflow\MainWorkflowRepository;
use App\Services\MainService;


class MainWorkflowService extends MainService
{

    /**
     * @var MainWorkflowRepository
     */
    protected MainRepository $repository;

    /**
     * @param MainWorkflowRepository $repository
     */
    public function __construct(MainWorkflowRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param Filter|null $filter
     * @return mixed
     */
    public function allWithLastVersion(int $page, int $perPage,?Filter $filter = null): mixed
    {
        return $this->repository->allWithLastVersion($page, $perPage,$filter);
    }

    /**
     * formWithWorkFlow
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function formWithWorkFlow(int $page, int $perPage,?Filter $filter = null): mixed
    {
        return $this->repository->formWithWorkFlow($page, $perPage,$filter);
    }
  
    /**
     * lookupPaginate
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
   public function lookupPaginate(int $page, int $perPage,?Filter $filter = null): mixed
    {
        return $this->repository->lookupPaginate($page, $perPage,$filter);

    }
      /**
     * getDataExport
     *
     * @param  mixed $filter
     * @return void
     */
    public function getDataExport(?Filter $filter = null)
    {
        return $this->repository->allWithLastVersion(1, 2, $filter, false);
    }


}
