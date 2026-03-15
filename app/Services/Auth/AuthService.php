<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidLoginCredentialsException;
use App\Exceptions\AccountNotActiveException;
use App\Repository\Auth\UserRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Client as OClient;
use Throwable;
use Laravel\Passport\Token;


class AuthService extends MainService
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


    /**
     * @param string $email
     * @param string $password
     * @return mixed
     * @throws GuzzleException
     * @throws InvalidLoginCredentialsException|Throwable
     */
    public function login(string $email, string $password): mixed
    {
        $user = $this->firstOrFailBy(['email' => $email]);

        if (!$user->is_active)throw new InvalidLoginCredentialsException();

        $oClient = OClient::where('password_client', 1)->firstOrFail(); //@TODO: remove this after using it from .env
        $request = Request::create('oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => $oClient->id, //@TODO: use it from env
            'client_secret' => $oClient->secret, //@TODO: use it from env
            'username' => $email,
            'password' => $password,
            'scope' => '*',
        ]);
        $result = app()->handle($request);
        $tokenData =  json_decode($result->getContent(), true);

        if (!isset($tokenData['access_token'])) throw new InvalidLoginCredentialsException();

        $token = $user->tokens()->latest()->first();
        app(LoginHistoryService::class)->storeHistory($token->id,$user->id, $token->expires_at);
        $data = [];
        $data['user'] = $user;
        $data['accessToken'] = $tokenData['access_token'];
        $data['refreshToken'] = $tokenData['refresh_token'];
        $data['expiresIn'] = $tokenData['expires_in'];

        return (object)$data;
    }

    /**
     * @param string $refreshToken
     * @return mixed
     * @throws InvalidLoginCredentialsException
     */
    public function refresh(string $refreshToken): mixed
    {
        $oldTokenId =Auth::user()->tokens()->latest()->first()->id;
        $oClient = OClient::where('password_client', 1)->firstOrFail(); //@TODO: remove this after using it from .env
        $request = Request::create('oauth/token', 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $oClient->id, //@TODO: use it from env
            'client_secret' => $oClient->secret, //@TODO: use it from env
            'scope' => '*',
        ]);

        $result = app()->handle($request);
        $tokenData =  json_decode($result->getContent(), true);

        if (!isset($tokenData['access_token'])) throw new InvalidLoginCredentialsException();
        $newToken =Auth::user()->tokens()->latest()->first();
        app(LoginHistoryService::class)->updateHistory($oldTokenId, $newToken->id, Auth::id(),$newToken->expires_at);
        $data = [];
        $data['accessToken'] = $tokenData['access_token'];
        $data['refreshToken'] = $tokenData['refresh_token'];
        $data['expiresIn'] = $tokenData['expires_in'];
        return (object)$data;
    }

    /**
     * @return void
     */
    public function logout()
    {
        app(LoginHistoryService::class)->logoutHistory(Auth::user()->token()->id, Auth::id());
        Auth::user()->token()->revoke();
    }
     /**
      * logoutOtherSessions
      *
      * @return void
      */
     public function logoutOtherSessions()
    {
        $user = auth()->user();
        $currentTokenId = $user->token()->id;
        app(LoginHistoryService::class)->logoutOtherSessionsHistory($currentTokenId, $user->id);
        Token::where('user_id', $user->id)->where('id', '!=', $currentTokenId)->update(['revoked' => 1]);
    }
    /**
     * revokeSessionHistory
     *
     * @param  mixed $loginHistoryId
     * @return void
     */
    public function revokeSessionHistory($loginHistoryId)
    {Log::info($loginHistoryId);
        $history = app(LoginHistoryService::class)->firstOrFailBy(['id' => $loginHistoryId]);
        if ($history->token_id) {
            $token = \Laravel\Passport\Token::find($history->token_id);
            if ($token && !$token->revoked) {
                $token->revoke();
            }
        }
        app(LoginHistoryService::class)->logoutHistory($history->token_id, $history->user_id);
    }
}
