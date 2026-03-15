<?php

namespace App\Services;

use App\Repository\MainRepository;
use Closure;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Throwable;

class MainService
{
    /**
     * @var MainRepository
     */
    protected MainRepository $repository;

    /**
     * @var string
     */
    protected string $entity;

    /**
     * Create a new controller instance.
     * @param MainRepository $MainRepository
     */
    public function __construct(MainRepository $MainRepository)
    {
        $this->repository = $MainRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws Throwable
     */
    public function find($id): mixed
    {
        return $this->applyTransaction(function () use ($id) {
            return $this->repository->find($id);
        });
    }


    /**
     * @param int $id
     * @return mixed
     * @throws Throwable
     */
    public function findOrFail(int $id): mixed
    {
        return $this->applyTransaction(function () use ($id) {
            return $this->repository->findOrFail($id);
        });
    }

    /**
     * @param array $filters
     * @param array $with
     * @param array $withCount
     * @param array $columns
     * @return mixed
     * @throws Throwable
     */
    public function firstOrFailBy(array $filters = [], array $with = [], array $withCount = []): mixed
    {
        return $this->applyTransaction(function () use ($filters, $with, $withCount) {
            return $this->repository->firstOrFailBy($filters, $with, $withCount);
        });
    }

    /**
     * @param array $filters
     * @param array $with
     * @param array $withCount
     * @param array $columns
     * @return mixed
     * @throws Throwable
     */
    public function firstBy(array $filters = [], array $with = [], array $withCount = [], array $columns = ['*']): mixed
    {
        return $this->applyTransaction(function () use ($filters, $with, $withCount,  $columns) {
            return $this->repository->firstBy($filters, $with, $withCount, $columns);
        });
    }

    /**
     * @param Closure $callback
     * @return mixed
     * @throws Throwable
     */
    public function applyTransaction(Closure $callback): mixed
    {
        return $this->repository->applyTransaction($callback);
    }

    /**
     * @param array $filters
     * @param array $with
     * @param string $orderBy
     * @param string $direction
     * @param array $columns
     * @return mixed
     */
    public function findAll(array $filters = [], array $with = [], string $orderBy = 'created_at', string $direction = 'DESC', array $columns = ['*']): mixed
    {
        return $this->repository->findAll($filters, $with, $orderBy, $direction, $columns);
    }


    /**
     * @param string $column
     * @param array $ids
     * @param array $with
     * @return mixed
     */
    public function findAllByWhereIn(string $column, array $ids, array $with = []): mixed
    {
        return $this->repository->findAllByWhereIn($column, $ids, $with);
    }
    /**
     * @param mixed $data
     * @return mixed
     * @throws Throwable
     */
    public function add(mixed $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {
            return $this->repository->add($data);
        });
    }

    /**
     * @param array $search
     * @param array $create
     * @return mixed
     * @throws Throwable
     */
    public function firstOrCreate(array $search, array $create = []): mixed
    {
        return $this->applyTransaction(function () use ($search, $create) {
            return $this->repository->firstOrCreate($search, $create);
        });
    }


    /**
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function insert(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {
            return $this->repository->insert($data);
        });
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function insertOrIgnore(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {
            return $this->repository->insertOrIgnore($data);
        });
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function insertGetId(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {
            return $this->repository->insertGetId($data);
        });
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws EntityNotFoundException|Throwable
     */
    public function update(int $id, array $data): mixed
    {
        $this->findOrFail($id);
        return $this->applyTransaction(function () use ($id, $data) {
            return $this->repository->update($id, $data);
        });
    }


    /**
     * @param array $filters
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function updateManyWhere(array $filters, array $data): mixed
    {
        return $this->applyTransaction(function () use ($filters, $data) {
            return $this->repository->updateManyWhere($filters, $data);
        });
    }

    /**
     * @param string $column
     * @param array $ids
     * @param array $attributes
     * @return mixed
     * @throws Throwable
     */
    public function updateWhereIn(string $column, array $ids, array $attributes): mixed
    {
        return $this->applyTransaction(function () use ($column, $ids, $attributes) {
            return $this->repository->updateWhereIn($column, $ids, $attributes);
        });
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = []): mixed
    {
        return $this->repository->updateOrCreate($attributes, $values);
    }


    /**
     * @param array $ids
     * @return mixed
     * @throws Throwable
     */
    public function delete(array $ids): mixed
    {
        return $this->applyTransaction(function () use ($ids) {

            return $this->repository->delete($ids);
        });
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Throwable
     */
    public function deleteOne(int $id): mixed
    {
        return $this->applyTransaction(function () use ($id) {
            return $this->repository->deleteOne($id);
        });
    }


    /**
     * @param array $filters
     * @return mixed
     * @throws Throwable
     */
    public function deleteCollection(array $filters): mixed
    {
        return $this->applyTransaction(function () use ($filters) {
            return $this->repository->deleteCollection($filters);
        });
    }


    /**
     * @param string $column
     * @param array $where
     * @return mixed
     */
    public function max(string $column, array $where): mixed
    {
        return $this->repository->max($column, $where);
    }

    /**
     * @param string $column
     * @param array $where
     * @return mixed
     */
    public function min(string $column, array $where): mixed
    {
        return $this->repository->min($column, $where);
    }


    public function deleteCollectionBy(array $filters): mixed
    {
        return $this->repository->deleteCollectionBy($filters);
    }

    /**
     * changePicture
     *
     * @param mixed $id
     * @param int|null $fileId
     * @return mixed
     */
    public function handleSingleFileable(int $id, ?int $fileId, ?string $model = null): mixed
    {
        if ($fileId) {
            app(FileableService::class)->updateOrCreate([
                'file_id' => $fileId,
                'fileable_id' => $id,
                'fileable_type' => $model ?? $this->repository->model(),
            ], [
                'fileable_id' => $id,
                'fileable_type' => $model ?? $this->repository->model()
            ]);
        } else {
            app(FileableService::class)->deleteCollectionBy([
                'fileable_id' => $id,
                'fileable_type' => $model ?? $this->repository->model()
            ]);
        }

        return true;
    }
    /**
     * handleSingleFileableUpdate
     *
     * @param  mixed $id
     * @param  mixed $fileId
     * @param  mixed $model
     * @return mixed
     */
    public function handleSingleFileableUpdate(int $id, ?int $fileId, ?string $model = null): mixed
    {
        if ($fileId) {
            app(FileableService::class)->updateOrCreate([
                'fileable_id' => $id,
                'fileable_type' => $model ?? $this->repository->model(),
            ], [
                'fileable_id' => $id,
                'file_id' => $fileId,
                'fileable_type' => $model ?? $this->repository->model()
            ]);
        } else {
            app(FileableService::class)->deleteCollectionBy([
                'fileable_id' => $id,
                'fileable_type' => $model ?? $this->repository->model()
            ]);
        }

        return true;
    }
}
