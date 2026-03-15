<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\ComponentFormSubmissionRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class ComponentFormSubmissionService extends MainService
{
    /**
     * @var ComponentFormSubmissionRepository
     */

    protected MainRepository $repository;
    /**
     * @param ComponentFormSubmissionRepository $repository
     */

    public function __construct(ComponentFormSubmissionRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * filterStore
     *
     * @param  mixed $componentFilter
     * @param  mixed $componentId
     * @return void
     */
    public function filterStore(array $componentFilter, int $componentId): void
    {
        // $data = [];
        // foreach ($componentFilter as $index=>$filter) {
        //     $data[] = [
        //         'component_id' => $componentId,
        //         'filter' => [$index=>$filter],
        //     ];
        // }
        $this->insert(['component_id' => $componentId,"filter"=>json_encode($componentFilter)]);
    }
    /**
     * filterUpdate
     *
     * @param  mixed $componentFilter
     * @param  mixed $componentId
     * @return void
     */
    public function filterUpdate(array $componentFilter, int $componentId): void
    {
        $this->deleteCollectionBy(['component_id'=> $componentId]);
        $this->filterStore($componentFilter, $componentId);
    }
}
