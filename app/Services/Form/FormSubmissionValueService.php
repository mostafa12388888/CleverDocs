<?php

namespace App\Services\Form;

use App\Repository\Form\FormSubmissionValueRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use Exception;


class FormSubmissionValueService extends MainService
{

    /**
     * @var FormSubmissionValueRepository
     */
    protected MainRepository $repository;

    /**
     * @param FormSubmissionValueRepository $repository
     */
    public function __construct(FormSubmissionValueRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    /**
     * @param int $formSubmissionId
     * @param array $inputsValues
     * @return mixed
     */
    public function storeSubmissionValues(int $formSubmissionId, array $inputsValues): mixed
    {
        return $this->repository->storeSubmissionValue($formSubmissionId, $inputsValues);
    }

    /**
     * @param int $formSubmissionId
     * @param array $inputsValues
     * @return mixed
     */
    public function updateSubmissionValues(int $formSubmissionId, array $inputsValues): mixed
    {
        return $this->repository->updateSubmissionValue($formSubmissionId, $inputsValues);
    }

    /**
     * @param int $formSubmissionId
     * @return mixed
     */
    public function deleteSubmissionValues(int $formSubmissionId): mixed
    {
        return $this->deleteCollectionBy(['form_submission_id' => $formSubmissionId]);
    }

}
