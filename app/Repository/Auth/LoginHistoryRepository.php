<?php

namespace App\Repository\Auth;

use App\Enum\Authorization\StatusLoginHistoryEnum;
use App\Http\Filters\Filter;
use App\Models\LoginHistory;
use App\Repository\MainRepository;


class LoginHistoryRepository extends MainRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return LoginHistory::class;
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

        $query = $this->model;
        if ($filter)  $query = $query->filter($filter);
        return  $query->latest()->paginate($perPage, ['*'], 'page', $page);
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

        $query = $this->model;
        if ($filter)  $query = $query->filter($filter);
        return  $query->where('user_id', auth()->id())->where('status', StatusLoginHistoryEnum::ACTIVE)->latest()->paginate($perPage, ['*'], 'page', $page);
    }
    /**
     * logoutOtherSessionsHistory
     *
     * @param  mixed $tokenId
     * @param  mixed $userId
     * @return mixed
     */
    public function logoutOtherSessionsHistory($currentTokenId, int $userId): mixed
    {
        return $this->applyTransaction(function () use ($currentTokenId, $userId) {
            return $this->model
                ->where('user_id', $userId)
                ->where('token_id', '!=', $currentTokenId)
                ->where('status', StatusLoginHistoryEnum::ACTIVE)
                ->update([
                    'status' => StatusLoginHistoryEnum::EXPIRED,
                    'logged_out_at' => now(),
                ]);
        });
    }
}
