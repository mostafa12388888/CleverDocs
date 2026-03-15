<?php

namespace App\Services\Dashboard;

use App\Enum\Dashboard\SettingEnum;
use App\Http\Filters\Filter;
use App\Repository\Dashboard\DashboardRepository;
use App\Repository\MainRepository;
use App\Services\MainService;

class DashboardService extends MainService
{
    /**
     * @var DashboardRepository
     */

    protected MainRepository $repository;
    /**
     * @param DashboardRepository $repository
     */

    public function __construct(DashboardRepository $repository)
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
        return $this->repository->index($page, $perPage, $filter);
    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookup(?Filter $filter = null): mixed
    {
        return $this->repository->lookup($filter);
    }
    /**
     * dashboardStore
     *
     * @param  mixed $dashboardData
     * @return mixed
     */
    public function dashboardStore(array $dashboardData): mixed
    {
        if ($dashboardData['is_default'] ?? false)
            $this->notDefaultDashboard();
        $dashboard = $this->add([
            'title' => $dashboardData['title'],
            'is_default' => $dashboardData['is_default'] ?? false,
            'settings' => $dashboardData['settings'] ?? SettingEnum::PRIVATE,
            'created_by' => auth()->id(),
        ]);

        if ($dashboard->settings == SettingEnum::PUBLIC) {
            $dashboard->users()->attach($dashboardData['userIds']);
        }
        return $dashboard;
    }
    /**
     * dashboardUpdate
     *
     * @param  mixed $dashboardData
     * @param  mixed $id
     * @return mixed
     */
    public function dashboardUpdate(array $dashboardData, int $id): mixed
    {
        if ($dashboardData['is_default'] ?? false)
            $this->notDefaultDashboard();
        $dashboard= $this->update($id, [
            'title' => $dashboardData['title'],
            'is_default' => $dashboardData['is_default'] ?? false,
            'settings' => $dashboardData['settings'] ?? SettingEnum::PRIVATE,
            'updated_by' => auth()->id(),
        ]);
        if ($dashboard->settings == SettingEnum::PUBLIC) {
            $dashboard->users()->sync($dashboardData['userIds']);
        }
        return $dashboard;
    }
    /**
     * notDefaultDashboard
     *
     * @return void
     */
    public function notDefaultDashboard(): void
    {
        $this->updateManyWhere(['created_by', auth()->id()], ['is_default' =>  false]);
    }
    /**
     * deleteUser
     *
     * @param  mixed $id
     * @return mixed
     */
    public function deleteDashboard(int $id): mixed
    {
        $user = $this->find($id);
        if (!$user) return false;
        $this->repository->update($id, ['deleted_by' => auth()->user()->id]);
        return $this->delete([$id]);
    }
    /**
     * bulkDelete
     *
     * @param  mixed $user
     * @return void
     */
    public function bulkDelete(array $user): void
    {

        $this->updateWhereIn("id",$user["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        $this->delete($user["ids"]);
    }
}
