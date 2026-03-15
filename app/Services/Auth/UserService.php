<?php

namespace App\Services\Auth;

use App\Repository\Auth\UserRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class UserService extends MainService
{
    /**
     * @var UserRepository
     */
    protected MainRepository $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(
        UserRepository $repository,
    ) {
        parent::__construct($repository);
    }


    public function authUser(){
        return auth()->user();
    }
    /**
     * loginHistoryData
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return void
     */
    public function loginHistoryData($page, $perPage, $filter) : mixed
    {
        return app(LoginHistoryService::class)->loginHistoryData($page, $perPage, $filter);
    }


}
