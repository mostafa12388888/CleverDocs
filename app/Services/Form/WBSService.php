<?php

namespace App\Services\Form;

use App\Exceptions\CantDeleteWpsHasProjectException;
use App\Exceptions\Wbs\CanDeleteWbsHasProjectException;
use App\Exceptions\Wbs\CantDeleteWpsHasChildrenException;
use App\Http\Filters\Filter;
use App\Repository\Form\WBSRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class WBSService extends MainService
{
    /**
     * @var WBSRepository
     */
    protected MainRepository $repository;
    /**
     * @param WBSRepository $repository
     */
    public function  __construct(WBSRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $limit
     * @return mixed
     */
    public function index(int $page, int $limit,?Filter $filter=null): mixed
    {
        return  $this->repository->index($page, $limit, $filter);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $limit
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $limit,?Filter $filter=null): mixed
    {
        return  $this->repository->lookupPaginate($page, $limit, $filter);
    }
       /**
     * getDataExport
     *
     * @param  mixed $filter
     * @return void
     */
    public function getDataExport(?Filter $filter = null)
    {
        return $this->repository->export($filter, false);
    }

    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {

        return $this->applyTransaction(function () use ($data) {
            return  $this->add(
                [
                    'title' => json_encode(['en' => $data['title']['en'], 'ar' => $data['title']['ar']]),
                    "created_by" => auth()->user()->id,
                    'w_b_s_id' => isset($data['parentId']) ? $data['parentId'] : null,
                ]
            );

        });
    }
    /**
     * update
     *
     * @param  mixed $wbsId
     * @param  mixed $data
     * @return mixed
     */
    public function  update(int $wbsId, array $data): mixed
    {

        return $this->applyTransaction(function () use ($wbsId, $data) {
            $wbs = $this->findOrFail($wbsId);
            return $this->repository->update(
                $wbs->id,
                [
                    'title' => json_encode($data['title']),
                    "updated_by" => auth()->user()->id,
                ]
            );
        });
    }


    /**
     * destroy
     *
     * @param  mixed $wbsId
     * @return mixed
     */
    public function destroy(int $wbsId): mixed
    {
        $wbs=$this->find($wbsId);
        if(!$wbs)return false;
        $this->_validateDelete($wbsId);
        $this->repository->update($wbsId, ['deleted_by' => auth()->user()->id]);
        return $this->delete([$wbsId]);

    }
    /**
     * bulkDelete
     *
     * @param  mixed $wbsId
     * @return mixed
     */
    public function bulkDelete(array $wbs): void
    {
        $idDelete=[];
        $ids=[];
        foreach ($wbs["ids"] as $wbsId){
            $wbs= $this->firstBy(['id' => $wbsId], withCount: ['projects',"chiles"]);
            if ($wbs?->projects->count()) $ids[]=trans('validation.messages.cant_delete_has_projects').$wbs->title;
            else if ($wbs?->chiles->count())$ids[]=trans('validation.messages.cant_delete_has_children').$wbs->title;
            else $idDelete[]=$wbsId;
        }
        $this->repository->updateWhereIn("id",$idDelete, [
            'deleted_by' => auth()->user()->id,
        ]);
        $this->delete($idDelete);

        $this->_validateDeleteArray($ids);
    }
    /**
     * _validateDelete
     *
     * @param  mixed $id
     * @return void
     */
    public function _validateDelete($id): void
    {

        $wbs = $this->firstOrFailBy(['id' => $id], withCount: ['projects',"chiles"]);
        if ($wbs?->projects->count()) throw new CantDeleteWpsHasProjectException();
        if ($wbs?->chiles->count()) throw new CantDeleteWpsHasChildrenException();
    }
    /**
     * _validateDeleteArray
     *
     * @param  mixed $deleteArray
     * @return void
     */
    private function _validateDeleteArray(array $deleteArray): void
    {
        if(!empty($deleteArray)) throw new CanDeleteWbsHasProjectException(errors :$deleteArray);
    }

}
