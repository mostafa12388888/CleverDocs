<?php

namespace App\Services;

use App\Http\Filters\Filter;
use App\Repository\AuditLogRepository;
use App\Repository\MainRepository;


class AuditLogService extends MainService
{
    /**
     * @var AuditLogRepository
     */
    protected MainRepository $repository;

    /**
     * @param AuditLogRepository $repository
     */
    public function __construct(AuditLogRepository $repository)
    {
        parent::__construct($repository);
    }
    /**
     * log
     *
     * @param  mixed $action
     * @param  mixed $modelType
     * @param  mixed $modelId
     * @param  mixed $old
     * @param  mixed $new
     * @return void
     */
    public function log(string $action = "create", string $modelType, int $modelId, ?array $oldValue = null, ?array $newValue = null, ?array $oldRelated = null, ?array $newRelated = null): void
    {
        $this->add([
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            "old_related_data" => $oldRelated,
            "new_related_data" => $newRelated,
            'old_values' => $oldValue,
            'new_values' => $newValue,
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $moduleType
     * @param  mixed $filter
     * @return mixed
     */
    public function index(int $page, int $perPage, string $moduleType, ?Filter $filter = null): mixed
    {
        return $this->repository->index($page, $perPage, $moduleType, $filter);
    }
}
