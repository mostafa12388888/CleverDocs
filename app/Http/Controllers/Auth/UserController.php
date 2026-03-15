<?php

namespace App\Http\Controllers\Auth;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\Company\LoginHistoryFilter;
use App\Http\Resources\CompanyAbout\LoginHistoriesResource;
use App\Http\Resources\User\UserAccountResource;
use App\Services\Auth\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{


    /**
     * @var UserService
     */
    private UserService $service;

    /**
     * @param UserService $UserService
     */
    public function __construct(UserService $UserService)
    {
        $this->service = $UserService;
    }


    /**
     * @return JsonResponse
     */
    public function myAccount(): JsonResponse
    {
        $resource = $this->service->authUser();
        return $this->response(new UserAccountResource($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * loginHistoryData
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function loginHistoryData(Request $request,LoginHistoryFilter $filter): JsonResponse
    {
        $paginator =$this->service->loginHistoryData($request->get('page',PaginationEnum::PAGE),$request->get("perPage", PaginationEnum::LIMIT),$filter);
        $resource=LoginHistoriesResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator),HttpStatusCodeEnum::OK);
    }


}
