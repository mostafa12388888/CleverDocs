<?php

namespace App\Services\Distribution;

use App\Enum\Form\PrivateInBoxStatusEnum;
use App\Http\Filters\Filter;
use App\Repository\Distribution\DistributionInboxRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class DistributionInboxService extends MainService
{
    /**
     * @var DistributionInboxRepository
     */
    protected MainRepository $repository;
    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function __construct(DistributionInboxRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function index(int $page, int $perPage, ?Filter $filter): mixed
    {
        return $this->repository->index($page, $perPage, $filter);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage, ?Filter $filter): mixed
    {
        return $this->repository->lookupPaginate($page, $perPage, $filter);
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
                'message' => $data["message"],
                'type' => $data['type'],
                'type_id' => $data['typeId'],
                "project_id"=>$data['projectId'] ?? null,
                'priority_id' => $data['priorityId'],
                'distribution_list_id' => $data['distributionListId'],
                "created_by" => auth()->user()->id,
            ]);

            foreach ($data['contactsActions'] as $contactsAction) {
                $distribution->contacts()->attach($contactsAction["id"], [
                    'action_id' => $contactsAction["actionId"],
                ]);
            }



            return 1;
        });
    }
    /**
     * updateMessage
     *
     * @param  mixed $messagesIds
     * @return mixed
     */
    public function markAsRead(array $messagesIds): mixed
    {
        return $this->updateWhereIn('id', $messagesIds, ["status" => PrivateInBoxStatusEnum::READ]);
    }
/**
 * countUnreadForCurrentUser
 *
 * @return int
 */
public function countUnreadForCurrentUser()
{
    return $this->repository->countUnreadForContact(auth()->user()->contact_id);
}

    /**
     * getPrivateMessageForCurrentUser
     *
     * @return mixed
     */
    public function getPrivateMessageForCurrentUser(int $page,int $perPage): mixed
    {
        $contactId = auth()->user()->contact_id;
        return $this->repository->getForContact( $page, $perPage,$contactId,['contacts','priority','action','createdBy','updatedBy','project','project.wbs']);
    }
}
