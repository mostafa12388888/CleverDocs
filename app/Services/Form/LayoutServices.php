<?php

namespace App\Services\Form;

use App\Http\Filters\Filter;
use App\Http\Filters\Layout\LayoutFilter;
use App\Repository\Form\LayoutRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use Throwable;


class LayoutServices extends MainService
{
    /**
     * @var LayoutRepository
     */
    protected MainRepository $repository;

    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function __construct(LayoutRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }



    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function index( ?Filter $filter=null, int $page, int $perPage): mixed
    {
        return $this->repository->index($filter, $page, $perPage);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $filter
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function lookupPaginate( ?Filter $filter=null, int $page, int $perPage): mixed
    {
        return $this->repository->lookupPaginate($filter, $page, $perPage);
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
     * store
     *
     * @param mixed $data
     * @return mixed
     * @throws Throwable
     */
    public function store(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {
            $layout =  $this->add([
                "subject" => $data["subject"]? json_encode($data["subject"]) : null,
                "status" => $data["status"],
                "type" => $data["type"],
                "project_id" => $data["projectId"],
                "module_id" => $data["moduleId"],
                "created_by" => auth()->user()->id,
            ]);

            $this->_handleImage($layout->id, $data["imageId"] ?? null);

            return $layout;
        });

    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function update(int $id, array $data): mixed
    {
        return $this->applyTransaction(function () use ($id, $data) {
            $layoutData = $this->findOrFail($id);
            $layout =  $this->repository->update($id, [
                "subject" => $data["subject"],
                "type" => $data["type"],
                "status" => $data["status"],
                "project_id" => $data["projectId"],
                "module_id" => $data["moduleId"],
                "updated_by" => auth()->user()->id,
            ]);

            $this->handleSingleFileableUpdate($id, $data["imageId"] ?? null);

            return $layout;
        });
    }

    /**
     * deleteLayout
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteLayout(int $id): mixed
    {
        $layoutData = $this->find($id);
        if(!$layoutData) return false;
        if (!is_null($layoutData->image)) {
            deleteImage($layoutData->image, "logo");
        }
        $this->repository->update($id, [
            "deleted_by" => auth()->user()->id,
        ]);
        return $this->delete([$id]);
    }
    /**
     * bulkDelete
     *
     * @param  mixed $wbsId
     * @return mixed
     */
    public function bulkDelete(array $layout): mixed
    {
        $this->repository->updateWhereIn("id",$layout["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        return $this->delete($layout["ids"]);
    }

    private function _handleImage($id, ?int $fileId)
    {
        $this->handleSingleFileable($id, $fileId);
    }
}
