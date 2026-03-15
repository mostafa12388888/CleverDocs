<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\MainWorkflowWatcherRepository;
use App\Services\MainService;
use Exception;


class MainWorkflowWatcherService extends MainService
{

    /**
     * @var MainWorkflowWatcherRepository
     */
    protected MainRepository $repository;

    /**
     * @param MainWorkflowWatcherRepository $repository
     */
    public function __construct(MainWorkflowWatcherRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    /**
     * @param int $mainWorkflowId
     * @param array $watchers
     * @return mixed
     * @throws \Throwable
     */
    public function  addMainWorkflowWatchers(int $mainWorkflowId, array $watchers): mixed
    {
        return $this->applyTransaction(function () use ($mainWorkflowId, $watchers) {
            $this->deleteCollection(['main_workflow_id' => $mainWorkflowId]);
            $watchers = array_map(function ($watcher) use ($mainWorkflowId) {
                return [
                    'user_id' => $watcher,
                    'main_workflow_id' => $mainWorkflowId
                ];
            }, $watchers);

            return $this->insert($watchers);
        });
    }

}
