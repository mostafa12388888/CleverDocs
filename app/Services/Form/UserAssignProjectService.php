<?php

namespace App\Services\Form;

use App\Repository\Form\UserAssignProjectRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use Throwable;

class UserAssignProjectService extends MainService
{

    /**
     * @var UserAssignProjectRepository
     */
    protected MainRepository $repository;

    /**
     * @param UserAssignProjectRepository $repository
     */
    public function __construct(UserAssignProjectRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    /**
     * @param int $userId
     * @param array $assignProjects
     * @return mixed
     * @throws Throwable
     */
    public function assignProjectsToUser(int $userId, array $assignProjects): mixed
    {
        return $this->applyTransaction(function () use ($userId, $assignProjects) {
            $this->repository->deleteCollectionBy(['user_id' => $userId]);
            $data = [];
            foreach ($assignProjects as $projectId) {
                $data[] = [
                    'project_id' => $projectId,
                    'user_id' => $userId,
                ];
            }
            $this->insert($data);
        });
    }
/**
 * assignProjectsToUsers
 *
 * @param  mixed $userIds
 * @param  mixed $projectIds
 * @return mixed
 */
public function assignProjectsToUsers(array $userIds, array $projectIds): mixed
{
    return $this->applyTransaction(function () use ($userIds, $projectIds) {
        $data = [];
        foreach ($userIds as $userId) {
            foreach ($projectIds as $projectId) {
                $data[] = [
                    'user_id'    => $userId,
                    'project_id' => $projectId,
                ];
            }
        }

        return $this->insert($data);
    });
}

    /**
     * @param $projectId
     * @param array $userIds
     * @return mixed
     * @throws Throwable
     */
    public function assignUserToProject($projectId, array $userIds): mixed
    {
        return $this->applyTransaction(function () use ($projectId, $userIds) {
            $this->repository->deleteCollectionBy(['project_id' => $projectId]);
            $data = [];
            foreach ($userIds as $userId) {
                $data[] = [
                    'project_id' => $projectId,
                    'user_id' => $userId,
                ];
            }

            $this->insert($data);
        });
    }





}
