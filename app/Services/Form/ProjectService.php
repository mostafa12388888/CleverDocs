<?php

namespace App\Services\Form;

use App\Exceptions\CanDeleteProjectHastWbsException;
use App\Exceptions\Form\CanDeleteProjectSubmissionException;
use App\Http\Filters\Filter;
use App\Jobs\AssignFormsToProjectsJob;
use App\Repository\Form\ProjectRepository;
use App\Repository\MainRepository;
use App\Services\FileableService;
use App\Services\MainService;
use Throwable;

class ProjectService extends MainService
{
    /**
     * @var ProjectRepository
     */
    protected MainRepository $repository;
    /**
     * @param ProjectRepository $repository
     */
    public function  __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * index
     *
     * @param mixed $page
     * @param mixed $limit
     * @param Filter|null $filter
     * @return mixed
     */

    public function index(int $page, int $perPage,?Filter $filter=null): mixed
    {
        return  $this->repository->index($page, $perPage, $filter);
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
     * lookupProject
     *
     * @return mixed
     */
    public function lookupProject(?Filter $filter=null): mixed
    {
        return $this->repository->lookupProject($filter);
    }

    /**
     * storeProject
     *
     * @param mixed $data
     * @return mixed
     * @throws Throwable
     */
    public function storeProject(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data): mixed {
            $project= $this->add([
                'w_b_s_id' => $data['wbsId'] ,
                'status' => $data['status'] ?? 0,
                'country_id' => $data['countryId'] ?? null,
                'company_id' => $data['companyId'] ?? null,
                'contact_id' => $data['contactId'] ?? null,
                'project_type_id' => $data['projectTypeId'] ?? null,
                'contract_value' => $data['contractValue'] ?? NULL,
                'description' => $data['description'] ?? NULL,
                'reference_number' => $data['referenceNumber'] ?? NULL,
                'order' => $this->max("order",["w_b_s_id"=>$data['wbsId']])+1,
                "created_by" => auth()->user()->id,
                'name' => json_encode($data['name']),
            ]);
            dispatch(new AssignFormsToProjectsJob($project->id));

            $this->_handleProjectLogo($project, $data['logoId'] ?? null);
            return $project;
        });
    }
    /**
     * assignCompany
     *
     * @param  mixed $data
     * @return mixed
     */
    public function assignCompany(array $data): mixed
    {
        foreach($data["companyIds"] as $index=>$companyId)
        foreach($data["projectIds"] as $projectId)
        $assignCompanyData[]=[

                "company_id"=>$companyId,
                "project_id"=>$projectId,
    ];
     return App(ProjectAssignedCompanyService::class)->insert($assignCompanyData);
    }

    /**
     * updateProject
     *
     * @param mixed $data
     * @param mixed $id
     * @return mixed
     * @throws Throwable
     */
    public function updateProject(array $data, int $id): mixed
    {
        return $this->applyTransaction(function () use ($data, $id): mixed {
            $projectData = $this->findOrFail($id);
            $project = $this->update($id, [
                'w_b_s_id' => $data['wbsId'] ?? null,
                'status' => $data['status'] ?? 0,
                'country_id' => $data['countryId'] ?? null,
                'company_id' => $data['companyId'] ?? null,
                'contact_id' => $data['contactId'] ?? null,
                'project_type_id' => $data['projectTypeId'] ?? null,
                'contract_value' => $data['contractValue'] ?? NULL,
                'description' => $data['description'] ?? NULL,
                'reference_number' => $data['referenceNumber'] ?? NULL,
                "updated_by" => auth()->user()->id,
                'name' => json_encode($data['name']),
            ]);

            $this->_handleProjectLogo($project, $data['logoId'] ?? null);

            return $project;
        });
    }


    /**
     * destroy
     *
     * @param mixed $wbsId
     * @return void
     * @throws CanDeleteProjectHastWbsException
     * @throws Throwable
     */
    public function destroy($projectId): mixed
    {
        $project = $this->find($projectId);
        if(!$project)return false;
        $this->_validateDelete($project);
       return $this->delete([$projectId]);
    }
    /**
     * bulkDelete
     *
     * @param  mixed $project
     * @return mixed
     */
    public function bulkDelete(array $project): void
    {
        foreach($project["ids"] as $id){
        $pro=$this->find($id);
        $this->_validateDelete($pro);
        }
        $this->repository->updateWhereIn("id",$project["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        $this->delete($project["ids"]);

    }

    /**
     * _validateDelete
     *
     * @param mixed $id
     * @return void
     * @throws CanDeleteProjectHastWbsException
     * @throws Throwable
     */
    public function _validateDelete($project): void
    {
        if($project->templateFormProjects()->exists()){
            $locale = app()->getLocale();
           $formNames = $project->templateForm()
            ->pluck('name')
            ->map(function ($name) use ($locale) {
                $decoded = is_string($name) ? json_decode($name, true) : $name;
                return $decoded[$locale] ?? reset($decoded);
            })->toArray();
           throw new CanDeleteProjectSubmissionException($formNames);

        }
    }
    /**
     * _validateDeleteArray
     *
     * @param  mixed $deleteArray
     * @return void
     */
    private function _validateDeleteArray(array $deleteArray): void
    {

    }
     /**
     * assignProjects
     *
     * @param  mixed $userId
     * @param  mixed $projects
     * @return void
     */
    public function assignProjectsToUser(int $userId,array $projects)
    {
        App(UserAssignProjectService::class)->assignProjectsToUser($userId,$projects);
    }
    /**
     * assignProjectsToUsers
     *
     * @param  mixed $userIds
     * @param  mixed $projects
     * @return void
     */
    public function assignProjectsToUsers(array $userIds,array $projects)
    {
        App(UserAssignProjectService::class)->assignProjectsToUsers($userIds,$projects);
    }
    /**
     * assignUserToProject
     *
     * @param  mixed $userId
     * @param  mixed $projects
     * @return void
     */
    public function assignUserToProject(int $projectId,array $users)
    {
        App(UserAssignProjectService::class)->assignUserToProject($projectId,$users);
    }

    /**
     * @param mixed $project
     * @param int|null $fileId
     * @return void
     */
    function _handleProjectLogo( mixed $project, ?int $fileId=null,): void
    {
        if ($fileId) {
            app(FileableService::class)->updateOrCreate([
                'file_id' => $fileId,
                'fileable_id' => $project->id,
                'fileable_type' => $this->repository->model(),
            ], [
                'fileable_id' => $project->id,
                'fileable_type' => $this->repository->model()
            ]);
        } else {
            app(FileableService::class)->deleteCollectionBy([
                'fileable_id' => $project->id,
                'fileable_type' => $this->repository->model()
            ]);
        }
    }

}
