<?php
namespace App\Services\Form;

use App\Repository\Form\ProjectAssignedCompanyRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class ProjectAssignedCompanyService extends MainService
{
    /**
     * @var ProjectAssignedCompanyRepository
     */
    protected MainRepository $repository;

    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function __construct(ProjectAssignedCompanyRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
}

