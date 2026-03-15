<?php

namespace App\Http\Controllers\CompanyAbout;

use App\Enum\Form\PrivateInBoxStatusEnum;
use App\Http\Controllers\Controller;
use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\CompanyAbout\privateInBoxExport;
use App\Http\Filters\Company\PrivateInBoxFilter;
use App\Http\Requests\Company\MarkReadPrivateInBoxRequest;
use App\Http\Requests\Company\SendPrivateInBoxRequest;
use App\Http\Resources\CompanyAbout\PrivateInBoxLookupResource;
use App\Http\Resources\CompanyAbout\PrivateInBoxResource;
use App\Http\Resources\CompanyAbout\PrivateInBoxUnReadCounterResource;
use App\Services\CompanyAbout\PrivateInBoxService;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;


class PrivateInBoxController extends Controller
{

    /**
     * service
     *
     * @var PrivateInBoxService
     */
    protected PrivateInBoxService $service;
    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(PrivateInBoxService $service)
    {
        $this->service = $service;
    }
    /**
     * index
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function index(Request $request, PrivateInBoxFilter $filter)
    {
        $paginator = $this->service->index(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resource = PrivateInBoxResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }

    /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupPaginate(Request $request,PrivateInBoxFilter $filter): JsonResponse
    {
        $paginator = $this->service->lookupPaginate(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = PrivateInBoxLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }

    /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(PrivateInBoxFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new privateInBoxExport($dataExport), 'privateInBoxes.xlsx');
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * readMessage
     *
     * @return JsonResponse
     */
    public function fromContact(Request $request): JsonResponse
    {
        $paginator = $this->service->findAllData(["from_contact_id" => auth()->user()->contact_id], ["project","project.wbs"],$request->get('perPage', PaginationEnum::LIMIT),$request->get('page', PaginationEnum::PAGE));
        $resource =PrivateInBoxResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * unReadMessage
     *
     * @return JsonResponse
     */
    public function unReadMessageCounter()
    {
        $resource = $this->service->findAll(["from_contact_id" => auth()->user()->contact_id,"status" => PrivateInBoxStatusEnum::UN_READ]);
        return $this->response(PrivateInBoxUnReadCounterResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * Update the specified resource in storage.
     */
    /**
     * update
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function markAsRead(MarkReadPrivateInBoxRequest $request)
    {

        $this->service->markAsRead($request->messagesIds);

        return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * store
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function sendMessage(SendPrivateInBoxRequest $request)
    {
        $this->service->sendMessage($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
