<?php

namespace App\Repository\Form;

use App\Enum\Dashboard\CountOrGroupByChartEnum;
use App\Exceptions\Dashboard\ChartInvalidException;
use App\Exceptions\Dashboard\InvalidColumnTypeException;
use App\Http\Filters\Filter;
use App\Models\Form\FormSubmission;
use App\Repository\MainRepository;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class FormSubmissionRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return FormSubmission::class;
    }


    /**
     * @param int $page
     * @param int $perPage
     * @param Filter|null $filter
     * @return mixed
     */
    public function all(int $page, int $perPage, ?Filter $filter = null): mixed
    {
        $query = $this->model->select(['form_submissions.*'])
            ->with(['createdBy', 'updatedBy', 'form']);

        if ($filter) $filter->apply($query);

        return $query->latest()->paginate($perPage, ['*'], 'page', $page);
    }


    /**
     * @param int $page
     * @param int $perPage
     * @param Filter|null $filter
     * @return mixed
     */
    public function mainTemplateSubmissions(int $mainTemplateId, int $page, int $perPage, ?Filter $filter = null): mixed
    {
        $query = $this->model->submissionMainTemplate($mainTemplateId);
        $filter?->apply($query);
        return $query->with(['createdBy', 'updatedBy', 'submissionValues', 'submissionValues.TemplateInput'])
            ->latest()->paginate($perPage, ['form_submissions.*'], 'page', $page);
    }
    /**
     * aggregatedCounts
     *
     * @param  mixed $filter
     * @param  mixed $mainTemplateId
     * @param  mixed $countBy
     * @param  mixed $groupBy
     * @return mixed
     */
    public function aggregatedCounts(Filter $filter, int $mainTemplateId, ?string $countBy = null, ?string $groupBy = null): mixed
    {
        $query = $this->model->submissionMainTemplate($mainTemplateId);
        $filter?->apply($query);

        $isCountSubmissionValue = $countBy && !$this->isEnumKey($countBy);
        $isGroupSubmissionValue = $groupBy && !$this->isEnumKey($groupBy);

        // : countBy from submission value
        if ($isCountSubmissionValue) {
            return $this->handleSubmissionValueAggregation($query, $countBy, $groupBy, $isGroupSubmissionValue);
        }

        // : groupBy from submission value
        if ($isGroupSubmissionValue) {
            return $this->handleSubmissionValueAggregation($query, $countBy, $groupBy, true);
        }

        // :   tow columns
        $countColumn = $countBy ? $this->resolveColumn($countBy) : null;
        $groupColumn = $groupBy ? $this->resolveColumn($groupBy) : null;

        if ($countColumn && $groupColumn) {
            $data = $query
                ->select(
                    DB::raw("{$groupColumn} as `group`"),
                    DB::raw("{$countColumn} as `title`"),
                    DB::raw("COUNT(*) as totalCount")
                )
                ->groupBy($groupColumn, $countColumn)
                ->get();

            return $data->groupBy('group')->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'title'      => $item->title,
                        'totalCount' => (int) $item->totalCount,
                    ];
                })->values();
            });
        }

        if ($countColumn && !$groupColumn) {
            return $query
                ->select(DB::raw("{$countColumn} as title"), DB::raw("COUNT(*) as totalCount"))
                ->groupBy($countColumn)
                ->get();
        }

        if (!$countColumn && $groupColumn) {
            return $query
                ->select(DB::raw("{$groupColumn} as title"), DB::raw("COUNT(*) as totalCount"))
                ->groupBy($groupColumn)
                ->get();
        }

        return $query->get();
    }
    /**
     * isEnumKey
     *
     * @param  mixed $key
     * @return bool
     */
    private function isEnumKey(string $key): bool
    {
        return in_array($key, CountOrGroupByChartEnum::getLocalConstants());
    }
    private function resolveColumn(string $type): string
    {
        // If it's already a valid column name, just return it
        if (str_contains($type, '.')) {
        return $type;
         }

        switch ($type) {
            case CountOrGroupByChartEnum::CREATED_BY:
                return 'form_submissions.created_by';
            case CountOrGroupByChartEnum::UPDATED_BY:
                return 'form_submissions.updated_by';
            case CountOrGroupByChartEnum::CREATED_AT:
                return 'form_submissions.created_at';
            case CountOrGroupByChartEnum::UPDATED_AT:
                return 'form_submissions.updated_at';
            case CountOrGroupByChartEnum::PROJECT:
                return 'templates_form_projects.project_id';
            default:
                throw new InvalidColumnTypeException(__('validation.attributes.'.$type));
        }
    }
    /**
     * handleSubmissionValueAggregation
     *
     * @param  mixed $query
     * @param  mixed $countBy
     * @param  mixed $groupBy
     * @param  mixed $groupIsSubmissionValue
     * @return void
     */
    private function handleSubmissionValueAggregation($query, ?string $countBy, ?string $groupBy, bool $groupIsSubmissionValue)
    {
        // if countBy from submission values
        if ($countBy && !$this->isEnumKey($countBy)) {
            $query->join('form_submission_values as count_table', function ($join) use ($countBy) {
                $join->on('count_table.form_submission_id', '=', 'form_submissions.id')
                    ->where('count_table.input_key', $countBy);
            });
        }

        // if groupBy from submission values
        if ($groupBy && !$this->isEnumKey($groupBy)) {
            $query->join('form_submission_values as group_table', function ($join) use ($groupBy) {
                $join->on('group_table.form_submission_id', '=', 'form_submissions.id')
                    ->where('group_table.input_key', $groupBy);
            });
        }

        $countColumn = $countBy
            ? ($this->isEnumKey($countBy) ? $this->resolveColumn($countBy) : 'count_table.value')
            : null;

        $groupColumn = $groupBy
            ? ($this->isEnumKey($groupBy) ? $this->resolveColumn($groupBy) : 'group_table.value')
            : null;

        if ($countColumn && $groupColumn) {
            $data = $query
                ->select(
                    DB::raw("{$groupColumn} as `group`"),
                    DB::raw("{$countColumn} as `title`"),
                    DB::raw("COUNT(*) as totalCount")
                )
                ->groupBy($groupColumn, $countColumn)
                ->get();

            return $data->groupBy('group')->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'title'      => $item->title,
                        'totalCount' => (int) $item->totalCount,
                    ];
                })->values();
            });
        }

        if ($countColumn && !$groupColumn) {
            return $query
                ->select(DB::raw("{$countColumn} as title"), DB::raw("COUNT(*) as totalCount"))
                ->groupBy($countColumn)
                ->get();
        }

        if (!$countColumn && $groupColumn) {
            return $query
                ->select(DB::raw("{$groupColumn} as title"), DB::raw("COUNT(*) as totalCount"))
                ->groupBy($groupColumn)
                ->get();
        }

        return $query->get();
    }
    /**
     * versions
     *
     * @param  mixed $submissionId
     * @return Boolean
     */
    public function versions($submissionId) : bool
    {
        return $this->model->where('submissions_id', $submissionId)->exists();
    }
   


}










