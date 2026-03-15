<?php

namespace App\Services\CompanyAbout;

use App\Enum\Form\PrivateInBoxStatusEnum;
use App\Http\Filters\Filter;
use App\Repository\CompanyAbout\PrivateInBoxRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class PrivateInBoxService extends MainService
{


    /**
     * repository
     *
     * @var PrivateInBoxRepository
     */
    protected MainRepository $repository;


    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function __construct(PrivateInBoxRepository $repository)
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
    public function lookupPaginate(int $page, int $perPage,?Filter $filter=null): mixed
    {
        return  $this->repository->lookupPaginate($page, $perPage, $filter);
    }
    /**
     * findAllData
     *
     * @param  mixed $filters
     * @param  mixed $with
     * @return mixed
     */
    public function findAllData(array $filters = [], array $with, int $perPage, int $page): mixed
    {
        return  $this->repository->findAllQuery($filters, $with,columns:["private_in_boxes.*"])->withResolvedName()->paginate($perPage,"*","page",$page);
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
    public function sendMessage(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {
            $privateInBox = [];
            foreach ($data["contactsIds"] as $index => $contactId)
                $privateInBox[$index] = [
                    "message" => $data['message'],
                    'typeId' => $data['typeId'],
                    "project_id"=>$data['projectId'] ?? null,
                    'type' => $data['type'],
                    "created_by" =>auth()->id(),
                    'from_contact_id' => $contactId,
                ];
            $this->insert($privateInBox);
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
}
