<?php

namespace App\Http\Controllers;


use App\Enum\HttpStatusCodeEnum;
use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\FileUploadResource;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Throwable;

class FileController extends Controller
{
    /**
     * @var FileService
     */
    private FileService $service;

    public function __construct(FileService $FileService)
    {
        $this->service = $FileService;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param FileUploadRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function add(FileUploadRequest $request): JsonResponse
    {
        $uploadResults = $this->service->handleUpload($request->all());
        return $this->response(FileUploadResource::make($uploadResults), HttpStatusCodeEnum::OK);
    }
    

}
