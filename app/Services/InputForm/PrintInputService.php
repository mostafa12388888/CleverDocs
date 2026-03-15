<?php

namespace App\Services\InputForm;

use App\Repository\InputForm\PrintInputRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class PrintInputService extends MainService
{
    /**
     * @var PrintInputRepository
     */
    protected MainRepository $repository;

    /**
     * @param PrintInputRepository $repository
     */
    public function __construct(PrintInputRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }




}
