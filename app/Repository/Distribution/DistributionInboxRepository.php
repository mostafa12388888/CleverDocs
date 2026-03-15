<?php
namespace App\Repository\Distribution;
use App\Enum\Form\PrivateInBoxStatusEnum;

use App\Http\Filters\Filter;
use App\Models\Distribution\DistributionInbox;
use App\Repository\MainRepository;

class DistributionInboxRepository extends MainRepository
{

    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return DistributionInbox::class;
    }

    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function index(int $page,int $perPage,? Filter $filter=null):mixed
    {
        $query=$this->model->select('distribution_inboxes.*')->withResolvedName();

        if($filter) $query=$query->filter($filter);
        return $query->with('contacts','priority', 'action',"updatedBy","createdBy",'project')->latest()->paginate($perPage,"*","page",$page);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page,int $perPage,? Filter $filter=null):mixed
    {
        $query=$this->model;

        if($filter) $query=$query->filter($filter);
        return $query->select('distribution_inboxes.*')->latest()->paginate($perPage,"*","page",$page);
    }
    public function countUnreadForContact(int $contactId)
    {
        return $this->model->select('distribution_inboxes.*')
            ->where('status', PrivateInBoxStatusEnum::UN_READ)->forContact($contactId)
            ->count();
    }

    /**
     * findFirstForContact
     *
     * @param  mixed $contactId
     * @param  mixed $with
     * @return void
     */
    public function getForContact(int $page,int $perPage,int $contactId, array $with = [])
    {
        return $this->model->forContact($contactId)->with($with)->withResolvedName()->latest()->paginate($perPage,"*","page",$page);
    }


}
