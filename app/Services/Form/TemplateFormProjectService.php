<?php

namespace App\Services\Form;

use App\Repository\Form\TemplatesFormProjectRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use Throwable;

class TemplateFormProjectService extends MainService
{

    /**
     * @var TemplatesFormProjectRepository
     */
    protected MainRepository $repository;

    /**
     * @param TemplatesFormProjectRepository $repository
     */
    public function __construct(TemplatesFormProjectRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    /**
     * @param int $formId
     * @param array $projectIds
     * @throws Throwable
     */
    public function attachTemplateProjects(int $formId, array $projectIds)
    {
        $data = [];
        foreach ($projectIds as $projectId) {
            $data[] = [
                'project_id' => $projectId,
                'templates_form_id' => $formId,
            ];
        }

        $this->insert($data);
    }

    /**
     * @param int $projectId
     * @return void
     * @throws Throwable
     */
    public function attachPrimaryFormsToProject(int $projectId): void
    {
        $forms=App(FormService::class)->getPrimaryForm();
        if (!$forms || $forms->isEmpty()) {
            return;
        }

        $this->attachProjectsTemplateForm($projectId, $forms->pluck("id")->toArray());
    }

    /**
     * attachProjectsTemplateForm
     *
     * @param mixed $projectId
     * @param array $formsIds
     * @return void
     * @throws Throwable
     */
    public function attachProjectsTemplateForm(int $projectId, array $formsIds): void
    {
        $data = [];
        foreach ($formsIds as $formsId) {
            $data[] = [
                'project_id' => $projectId,
                'templates_form_id' => $formsId
            ];
        }

        $this->insert($data);
    }

}

