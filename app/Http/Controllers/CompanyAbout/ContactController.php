<?php

namespace App\Http\Controllers\CompanyAbout;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\CompanyAbout\ContactExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Filters\Contact\ContactFilter;
use App\Http\Requests\Company\ContactRequest;
use App\Http\Requests\Company\ContactRequestBulkDelete;
use App\Http\Resources\Company\ContactLookupResource;
use App\Http\Resources\Company\ContactSummaryResource;
use App\Http\Resources\Company\ContactResource;
use App\Services\CompanyAbout\ContactService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Company\MarkContactRequest;
use Illuminate\Http\Request;
use Throwable;


class ContactController extends Controller
{
    /**
     * @var ContactService
     */
    protected ContactService $service;

    /**
     * @param ContactService $service
     */
    public function __construct(ContactService $service)
    {
        return $this->service = $service;
    }

    /**
     * Listing of Contacts
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request,ContactFilter $filter): JsonResponse
    {
        $paginator = $this->service->index(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = ContactResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }

    /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(ContactFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new ContactExport($dataExport), 'contacts.xlsx');
    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookup(ContactFilter $filter):JsonResponse
    {

        $resource=ContactLookupResource::collection($this->service->lookup($filter));

        return $this->response($resource,HttpStatusCodeEnum::OK);
    }

     /**
      * lookupPaginate
      *
      * @param  mixed $request
      * @param  mixed $filter
      * @return JsonResponse
      */
     public function lookupPaginate(Request $request,ContactFilter $filter): JsonResponse
    {
        $paginator = $this->service->lookupPaginate(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = ContactLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    public function markContact(MarkContactRequest $request, int $id): JsonResponse
    {
        $resource = $this->service->markContact($id, $request->all());
        return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(ContactRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->all());
        return $this->response(ContactResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function show(int $id): JsonResponse
    {
        $resource = $this->service->findOrFail($id);
        return $this->response(ContactResource::make($resource), HttpStatusCodeEnum::OK);
    }
        /**
         * summary
         *
         * @param  mixed $contactId
         * @return JsonResponse
         */
        public function summary(int $contactId): JsonResponse
    {
        $resource = $this->service->firstOrFailBy(['id' => $contactId], ['company'],[], ['id', 'name']);
        return $this->response(ContactSummaryResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * @param ContactRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(ContactRequest $request, int $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->all());
        return $this->response(ContactResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->destroy($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(ContactRequestBulkDelete $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());
        return $this->response([], HttpStatusCodeEnum::OK);
    }

}
