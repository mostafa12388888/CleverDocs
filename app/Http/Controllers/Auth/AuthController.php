<?php

namespace App\Http\Controllers\Auth;

use App\Enum\HttpStatusCodeEnum;
use App\Exceptions\InvalidLoginCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Auth\RefreshResource;
use App\Services\Auth\AuthService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;


class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }


    /**
     * Handles Login Request
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws GuzzleException
     * @throws InvalidLoginCredentialsException|Throwable
     */

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->service->login($request->get('email'), $request->get('password'));
        return $this->response(new LoginResource($data), HttpStatusCodeEnum::OK);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->service->logout();
        return $this->response([], HttpStatusCodeEnum::OK);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidLoginCredentialsException
     */
    public function refresh(Request $request): JsonResponse
    {
        $data = $this->service->refresh($request->get('refreshToken') ?? $request->bearerToken());
        return $this->response(new RefreshResource($data), HttpStatusCodeEnum::OK);
    }
    /**
     * revokeSessionHistory
     *
     * @return JsonResponse
     */
    public function revokeSessionHistory($loginHistoryId): JsonResponse
    {
        $this->service->revokeSessionHistory($loginHistoryId);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * logoutOtherSessions
     *
     * @return JsonResponse
     */
    public function logoutOtherSessions(): JsonResponse
    {
        $this->service->logoutOtherSessions();
        return $this->response([], HttpStatusCodeEnum::OK);
    }

}
