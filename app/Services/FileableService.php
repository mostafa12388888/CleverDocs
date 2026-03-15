<?php
namespace App\Services;

use App\Repository\FileableRepository;
use App\Repository\MainRepository;


class FileableService extends MainService
{
    /**
     * @var FileableRepository
     */
    protected MainRepository $repository;

    /**
     * @param FileableRepository $repository
     */
    public function __construct(FileableRepository $repository)
    {
        parent::__construct($repository);
    }






}
