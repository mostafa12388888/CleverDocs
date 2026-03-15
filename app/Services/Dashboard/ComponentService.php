<?php

namespace App\Services\Dashboard;

use App\Http\Filters\Filter;
use App\Repository\Dashboard\ComponentRepository;
use App\Repository\MainRepository;
use App\Services\Form\FormSubmissionService;
use App\Services\Form\MainTemplateFormService;
use App\Services\MainService;
use Illuminate\Support\Facades\App;

class ComponentService extends MainService
{
    /**
     * @var ComponentRepository
     */

    protected MainRepository $repository;
    /**
     * @param ComponentRepository $repository
     */

    public function __construct(ComponentRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    public function getSubmissionData(array $data)
    {
        $component= $this->find($data['componentId']);
        $allLastFormVersionInputs = app(MainTemplateFormService::class)->allLastFormVersionInputs($component->form_id);

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
    public function componentChartLogic( ?Filter $filter = null, int $formId,?string $countBy = null, ?string $groupBy = null): mixed
    {

        return App(FormSubmissionService::class)->submissionMainTemplate($filter, $formId, $countBy, $groupBy);

    }
    /**
     * componentStore
     *
     * @param  mixed $componentData
     * @return mixed
     */
    public function componentStore(array $componentData): mixed
    {
        $component = $this->add([
            'title' => $componentData['title'],
            'is_private' => $componentData['isPrivate'] ?? true,
            'form_id' => $componentData['formId'],
            'group_by' => $componentData['groupBy'],
            'count_by' => $componentData['countBy'],
            "dashboard_id" => $componentData['dashboardId'],
            "chart_type" => $componentData['chartType'] ?? null,
            'color_record' => $componentData['colorRecord'],
            'created_by' => auth()->id(),
        ]);
        App(ComponentFormSubmissionService::class)->filterStore(
            $componentData['filters'] ?? [],
            $component->id
        );

        return $component;
    }
    /**
     * componentUpdate
     *
     * @param  mixed $componentData
     * @param  mixed $id
     * @return mixed
     */
    public function componentUpdate(array $componentData, int $id): mixed
    {
        return $this->applyTransaction(function () use ($componentData , $id) {
        $component=$this->findOrFail($id);
         $this->update($component->id, [
            'title' => $componentData['title'],
            'is_private' => $componentData['isPrivate'] ?? $component->is_private,
            'form_id' => $componentData['formId'],
            'dashboard_id' => $componentData['dashboardId'],
            'group_by' => $componentData['groupBy'],
            'count_by' => $componentData['countBy'],
            "chart_type" => $componentData['chartType'] ?? $component->chart_type,
            'color_record' => $componentData['colorRecord'],
            'updated_by' => auth()->id(),
        ]);
        App(ComponentFormSubmissionService::class)->filterUpdate(
            $componentData['filters'] ?? [],
            $component->id
        );
        return $component;
    });

    }

    /**
     * deleteUser
     *
     * @param  mixed $id
     * @return mixed
     */
    public function deleteComponent(int $id): mixed
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

        $this->updateWhereIn("id", $user["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        $this->delete($user["ids"]);
    }
}
