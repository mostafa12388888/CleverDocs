<?php

namespace App\Http\Controllers\Distribution;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\Distribution\DistributionInboxFilter;
use App\Http\Requests\Distribution\DistributionInboxRequest;
use App\Services\Distribution\DistributionInboxService;
use App\Http\Requests\Distribution\MarkReadDistributionInboxRequest;
use App\Http\Resources\CompanyAbout\PrivateInBoxUnReadCounterResource;
use App\Http\Resources\Distribution\DistributionInboxResource;
use App\Http\Resources\Distribution\DistributionInboxDetailsResource;
use App\Http\Resources\Distribution\DistributionInboxLookupResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class DistributionIboxController extends Controller
{

    /**
     * @var DistributionInboxService
     */
    protected DistributionInboxService $service;

    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(DistributionInboxService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */

    /**
     * index
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function index(Request $request, DistributionInboxFilter $filter)
    {
        $paginator = $this->service->index(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resource = DistributionInboxResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
    public function lookupPaginate(Request $request, DistributionInboxFilter $filter)
    {
        $paginator = $this->service->lookupPaginate(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resource = DistributionInboxLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * unReadMessage
     *
     * @return JsonResponse
     */
    public function unReadMessageCounter()
    {
    $count = $this->service->countUnreadForCurrentUser();
    return $this->response(PrivateInBoxUnReadCounterResource::make(['count' => $count]), HttpStatusCodeEnum::OK);
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
    public function store(DistributionInboxRequest $request): JsonResponse
    {
        $this->service->store($request->all());
        return $this->response([], HttpStatusCodeEnum::OK);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function markAsRead(MarkReadDistributionInboxRequest $request)
    {

        $this->service->markAsRead($request->messagesIds);

        return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * Display the specified resource.
     */
    /**
     * privateMessage
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function privateMessage(Request $request): JsonResponse
    {
        $paginator = $this->service->getPrivateMessageForCurrentUser(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT)
        );
                $resource = DistributionInboxResource::collection($paginator);

        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
}
