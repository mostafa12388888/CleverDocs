<?php

namespace App\Repository;

use App\Http\Filters\Filter;
use App\Models\AuditLog;
use App\Repository\MainRepository;

class AuditLogRepository extends MainRepository
{

    /**
     * @return string
     */

    public function model(): string
    {
        return  AuditLog::class;
    }
    public function index(int $page, int $perPage,string $moduleType,?Filter $filter = null): mixed
    {
        $query = $this->model;

        if ($filter) $query = $query->filter($filter);
        return $query->where("audit_logs.model_type","LIKE",'%'.$moduleType.'%')->latest()->paginate($perPage, ['*'], 'page', $page);
    }
}
