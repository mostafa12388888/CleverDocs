<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistsNotSoftDeleted implements Rule
{
    protected $table;
    protected $column;

    /**
     * Create a new rule instance.
     *
     * @param string $table The table name to check.
     * @param string $column The column to match (usually 'id').
     */
    public function __construct($table, $column = 'id')
    {
        $this->table = $table;
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        // Check if the record exists in the table and is not soft deleted
        return DB::table($this->table)
            ->where($this->column, $value)
            ->whereNull('deleted_at')
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('validation.soft_delete');
    }
}
