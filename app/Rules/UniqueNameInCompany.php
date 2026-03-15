<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueNameInCompany implements Rule
{
    protected $companyId;
    protected $ignoreId;

    public function __construct($companyId, $ignoreId = null)
    {
        $this->companyId = $companyId;
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value)
    {
        $nameJson = json_encode($value);

        $query = DB::table('contacts')
            ->where('company_id', $this->companyId)
            ->where('name', $nameJson);

        if ($this->ignoreId) {
            $query->where('id', '<>', $this->ignoreId);
        }

        return !$query->exists();
    }


    public function message()
    {
        return __('validation.unique_name_in_company');
    }
}
