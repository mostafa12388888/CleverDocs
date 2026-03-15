<?php

namespace App\Services\Distribution;

use App\Exceptions\Distribution\CanDeleteDistributionInbox;
use App\Http\Filters\Filter;
use App\Repository\Distribution\DistributionListRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class DistributionListService extends MainService
{
    /**
     * @var DistributionListRepository
     */
    protected MainRepository $repository;
    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function __construct(DistributionListRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    public function index(int $page, int $perPage,?Filter $filter): mixed
    {
        return $this->repository->index($page, $perPage,$filter);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage,?Filter $filter): mixed
    {
        return $this->repository->index($page, $perPage,$filter);
    }
       /**
     * getDataExport
     *
     * @param  mixed $filter
     * @return void
     */
    public function getDataExport(?Filter $filter = null)
    {
        return $this->repository->index(1, 2, $filter, false);
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
            $distribution = $this->add([
                'is_active' => $data["isActive"],
                'title' => $data['title'],
                "created_by" => auth()->user()->id,
                "project_id"=>$data["projectId"],
            ]);

            $syncData = [];
        foreach ($data['contactsActions'] as $contactsAction) {
            $syncData[$contactsAction["id"]] = [
                'action_id' => $contactsAction["actionId"],
            ];
        }
        $distribution->contacts()->sync($syncData);



            return $distribution;
        });
    }

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $distribution = $this->findOrFail($id);
         $this->repository->update($distribution->id, [
            'updated_by' => auth()->user()->id,
            'is_active' => $data["isActive"],
            'title' => $data['title'],
        ]);
        $syncData = [];
        foreach ($data['contactsActions'] as $contactsAction) {
            $syncData[$contactsAction["id"]] = [
                'action_id' => $contactsAction["actionId"],
            ];
        }
        $distribution->contacts()->sync($syncData);

        return $distribution;
    }
    /**
     * deleteDistributionList
     *
     * @param  mixed $id
     * @return mixed
     */
    public function deleteDistributionList(int $id): mixed
    {
        $distribution=$this->find($id);
        if(!$distribution) return false;
        $this->_validateDelete($distribution);
        $this->repository->update($id, ['deleted_by' => auth()->user()->id]);

       return $this->repository->delete([$id]);
    }
         /**
     * bulkDelete
     *
     * @param  mixed $wbsId
     * @return mixed
     */
    public function bulkDelete(array $distribution): mixed
    {

        $this->repository->updateWhereIn("id",$distribution["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        foreach ($distribution["ids"] as $id) {
            $inbox = $this->find($id);
            $this->_validateDelete($inbox);
        }
        return $this->delete($distribution["ids"]);
    }
    /**
     * _validateDelete
     *
     * @param  mixed $distribution
     * @return void
     */
    private function _validateDelete(object $distribution) :void
    {
        if ($distribution?->distributionInbox()->exists()) throw new CanDeleteDistributionInbox() ;

    }

}
