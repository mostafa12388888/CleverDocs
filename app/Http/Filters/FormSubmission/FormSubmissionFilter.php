<?php

namespace App\Http\Filters\FormSubmission;

use App\Http\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;

class FormSubmissionFilter extends MainFilter
{

    /**
     * Search method
     *
     * @param mixed $value
     * @return Builder
     */
    public function search(mixed $value = null): Builder
    {
        // TODO: Implement business search logic
        return $this->builder;
    }
    /**
     * name
     *
     * @param  mixed $value
     * @return Builder
     */
    function name(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('form_submissions.name', 'LIKE', '%' . $value . '%');
    }

    /**
     * project
     *
     * @param  mixed $value
     * @return Builder
     */
    public function projectId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder ;
        return $this->builder->where('templates_form_projects.project_id', $value);
    }

    /**
     * status
     *
     * @param  mixed $value
     * @return Builder
     */
    public function status(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('form_submissions.status', $value);
    }

    /**
     * key
     *
     * @param  mixed $value
     * @return Builder
     */
    public function key(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('form_submissions.key', 'LIKE', '%' . $value . '%');
    }
    /**
     * version
     *
     * @param  mixed $value
     * @return Builder
     */
    public function version(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('form_submissions.version', $value);
    }
    /**
     * symbol
     *
     * @param  mixed $value
     * @return Builder
     */
    public function symbol(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('form_submissions.symbol', 'LIKE', '%' . $value . '%');
    }
    /**
     * isDefault
     *
     * @param  mixed $value
     * @return Builder
     */
    public function isDefault(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('form_submissions.is_default', $value);
    }

       /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'form_submissions.updated_at'): Builder
    {
        return parent::updatedAt($startDate, $endDate, $columnName);
    }

    /**
     * createdAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'form_submissions.created_at'): Builder
    {
     return parent::createdAt($startDate, $endDate, $columnName);
    }
    /**
     * docDateEnd
     *
     * @param  mixed $value
     * @return Builder
     */
    public function docDateEnd($value): Builder
    {
        if (!$this->isJoined($this->builder, 'form_submission_values')) $this->_formSubmissionValueJoin();

        return $this->builder->where('form_submission_values.input_key', 'doc_date')->whereNotNull('form_submission_values.value->value')->where('form_submission_values.value->value', '<=', $value);
    }
    /**
     * docDateStart
     *
     * @param  mixed $value
     * @return Builder
     */
    public function docDateStart($value): Builder
    {
        if (!$value) return $this->builder;
        if (!$this->isJoined($this->builder, 'form_submission_values')) $this->_formSubmissionValueJoin();

        return $this->builder
            ->where('form_submission_values.input_key', 'doc_date')->whereNotNull('form_submission_values.value->value')
            ->where('form_submission_values.value->value', '>=', $value);
    }
    /**
     * createdBy
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function createdBy(string $value, string $columnName = 'form_submissions.created_by'): Builder
    {
        return parent::createdBy($value, $columnName);
    }
    /**
     * updatedBy
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedBy(string $value, string $columnName = 'form_submissions.updated_by'): Builder
    {
        return parent::updatedBy($value, $columnName);
    }
    public function _formSubmissionValueJoin(): void
    {
                $this->builder->leftJoin('form_submission_values','form_submission_values.form_submission_id','=','form_submissions.id');

    }
}
