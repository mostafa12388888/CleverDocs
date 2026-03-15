<?php

namespace App\Services\Auth;

use App\Enum\Authorization\StatusLoginHistoryEnum;
use App\Http\Filters\Filter;
use App\Repository\Auth\LoginHistoryRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;
use Laravel\Passport\Bridge\RefreshToken;
use GeoIP;

class LoginHistoryService extends MainService
{
    /**
     * @var LoginHistoryRepository
     */
    protected MainRepository $repository;

    /**
     * @param LoginHistoryRepository $repository
     */
    public function __construct(LoginHistoryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function index(int $page, int $perPage, ?Filter $filter = null): mixed
    {
        return  $this->repository->index($page, $perPage, $filter);
    }
    /**
     * loginHistoryData
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function loginHistoryData(int $page, int $perPage, ?Filter $filter = null): mixed
    {
        return  $this->repository->loginHistoryData($page, $perPage, $filter);
    }
    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function storeHistory($tokenId, $userId, $expireAt): mixed
    {
        return $this->applyTransaction(function () use ($tokenId, $userId, $expireAt) {
            $agent = new Agent();
            $browser = $agent->browser();
            if ($agent->isMobile()) {
                $device = 'mobile';
            } elseif ($agent->isTablet()) {
                $device = 'tablet';
            } else {
                $device = 'desktop';
            }
            $os = $agent->platform();
            $ip = request()->header('CF-Connecting-IP')
                ?? request()->header('X-Forwarded-For')
                ?? request()->ip();
            // $locationData = geoip(request()->ip());
            $location=null;
            // $location = collect([
            //     $locationData->city,
            //     $locationData->state,
            //     $locationData->country,
            // ])->filter()->implode(', ');

            return  $this->add([
                'user_id' => $userId,
                // 'token_id' => $tokenId,
                'ip' => $ip,
                'browser' => $browser,
                'os' => $os,
                'device'     => $device,
                'location' => $location,
                'expires_at' => $expireAt,
            ]);
        });
    }
    /**
     * updateHistory
     *
     * @param  mixed $oldTokenId
     * @param  mixed $newTokenId
     * @param  mixed $userId
     * @return mixed
     */
    public function updateHistory($oldTokenId, $newTokenId, $userId, $expireAt): mixed
    {
        return $this->applyTransaction(function () use ($oldTokenId, $newTokenId, $userId, $expireAt) {
            return $this->updateManyWhere(['token_id' => $oldTokenId, "user_id" => $userId, 'status' => StatusLoginHistoryEnum::ACTIVE], [
                'token_id' => $newTokenId,
                'expires_at' => $expireAt,
            ]);
        });
    }
    /**
     * logoutHistory
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function logoutHistory($tokenId, int $userId): mixed
    {
        return $this->applyTransaction(function () use ($tokenId, $userId) {
            return $this->updateManyWhere(['token_id' => $tokenId, "user_id" => $userId], [
                'logged_out_at' => now(),
                'status' => StatusLoginHistoryEnum::EXPIRED,
            ]);
        });
    }
    /**
     * logoutOtherSessionsHistory
     *
     * @param  mixed $currentTokenId
     * @param  mixed $userId
     * @return mixed
     */
    public function logoutOtherSessionsHistory($currentTokenId, int $userId): mixed
    {
        return $this->repository->logoutOtherSessionsHistory($currentTokenId, $userId);
    }
    /**
     * revokeSessionHistory
     *
     * @param  mixed $loginHistoryId
     * @return void
     */
    public function revokeSessionHistory($loginHistoryId)
    {

        $history = $this->repository->firstOrFailBy(['id' => $loginHistoryId]);
        if ($history->token_id) {
            $token = \Laravel\Passport\Token::find($history->token_id);
            if ($token && !$token->revoked) {
                $token->revoke();
            }
        }

        $history->update([
            'status' => StatusLoginHistoryEnum::EXPIRED,
            'logged_out_at' => now(),
        ]);
    }
}
