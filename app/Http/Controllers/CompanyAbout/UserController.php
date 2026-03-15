<?php

namespace App\Http\Controllers\CompanyAbout;

use App\Enum\Company\AvatarEnum;
use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\Company\UserFilter;
use App\Http\Requests\Comany\UpdatePasswordRequest;
use App\Http\Requests\Comany\UpdateUserPasswordRequest;
use App\Http\Requests\Comany\UserRequest;
use App\Http\Requests\Comany\UserUpdateRequest;
use App\Http\Requests\Company\UserSignatureRequest;
use App\Http\Resources\CompanyAbout\UserListResource;
use App\Http\Resources\CompanyAbout\UserResource;
use App\Services\CompanyAbout\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Company\ChangeMyPictureRequest;
use App\Http\Requests\Company\ChangePictureRequest;
use App\Http\Requests\Company\UserRequestBulkDelete;
use App\Http\Resources\CompanyAbout\UserLookUpPaginateResource;
use App\Exports\CompanyAbout\UsersExport;
use App\Http\Requests\Company\AvatarRequest;
use App\Http\Resources\FileResource;
use Maatwebsite\Excel\Facades\Excel;
class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $service;
    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }


    /**
     * Display a listing of the resource.
     */
    /**
     * index
     *
     * @param mixed $request
     * @param UserFilter $filter
     * @return JsonResponse
     */
    public function index(Request $request,UserFilter $filter):JsonResponse
    {
        $paginator =$this->service->index($request->get('page',PaginationEnum::PAGE),
        $request->get("perPage", PaginationEnum::LIMIT),$filter);
        $resource=UserListResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator),HttpStatusCodeEnum::OK);
    }
        /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
    public function export(UserFilter $filter)
    {
        $users = $this->service->getUsersForExport($filter);
        return Excel::download(new UsersExport($users), 'users.xlsx');
    }


    public function lookUpPagination(Request $request,UserFilter $filter):JsonResponse
    {
        $paginator =$this->service->lookUpPagination($request->get('page',PaginationEnum::PAGE),
        $request->get("perPage", PaginationEnum::LIMIT),$filter);
        $resource=UserLookUpPaginateResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator),HttpStatusCodeEnum::OK);

    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * store
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function store(UserRequest $request):JsonResponse
    {
        $resource=$this->service->store($request->all());
        return $this->response(UserResource::make($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * Display the specified resource.
     */
    /**
     * show
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show(int $id):JsonResponse
    {
        $resource =$this->service->show($id);
        return $this->response(UserResource::make($resource),HttpStatusCodeEnum::OK);
    }
/**
     * changeMyPicture
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function changeMyPicture(ChangeMyPictureRequest $request):JsonResponse
    {
        $resource=$this->service->changeMyPicture($request->all());
        return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * updateAvatar
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function updateAvatar(AvatarRequest $request):JsonResponse
    {
        $this->service->updateAvatar($request->all());
        return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * getAvatars
     *
     * @return JsonResponse
     */
    public function getAvatars():JsonResponse
    {
        return $this->response(AvatarEnum::getLocalConstants(), HttpStatusCodeEnum::OK);
    }
    /**
     * changePicture
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function changePicture(ChangePictureRequest $request):JsonResponse
    {
        $resource=$this->service->changePicture($request->all());
        return $this->response([], HttpStatusCodeEnum::OK);
    }
     /**
     * addSignature
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function addSignature(UserSignatureRequest $request)
    {
        $this->service->handleSingleFileable(auth()->id(),$request["signatureId"],"signatureUser");
         return $this->response(FileResource::collection(auth()->user()->signature),HttpStatusCodeEnum::OK);
    }
    /**
     * getSignature
     *
     * @return JsonResponse
     */
    public function getSignature():JsonResponse
    {
         return $this->response(FileResource::collection(auth()->user()->signature),HttpStatusCodeEnum::OK);
    }

/**
 * updatePassword
 *
 * @param  mixed $request
 * @param  mixed $id
 * @return JsonResponse
 */
public function updatePassword(UpdatePasswordRequest $request,int $id):JsonResponse
{

    $resource=$this->service->updatePassword($request->all(), $id);
    return $this->response(UserResource::make($resource),HttpStatusCodeEnum::OK);
}
/**
 * updateUserPassword
 *
 * @param  mixed $request
 * @param  mixed $id
 * @return JsonResponse
 */
public function updateUserPassword(UpdateUserPasswordRequest $request):JsonResponse
{

    $resource=$this->service->updateUserPassword($request->all());
            return $this->response(UserResource::make($resource), HttpStatusCodeEnum::OK);

}

    /**
     * Update the specified resource in storage.
     */
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        $resource=$this->service->update($id, $request->all());
        return $this->response(UserResource::make($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * destroy
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function destroy(int $id):JsonResponse
    {
        $this->service->deleteUser($id);
        return  $this->response([], HttpStatusCodeEnum::OK);
    }
         /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(UserRequestBulkDelete $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
