<?php

namespace App\Rules\Dashboard;

use App\Enum\Dashboard\CountOrGroupByChartEnum;
use Illuminate\Support\Facades\DB;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CountOrGroupByRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //  1. check if exists in Enum
        if (in_array($value, CountOrGroupByChartEnum::getLocalConstants(), true)) {
            return; // valid
        }

        //  2. check if exists in DB table
        $existsInDb = DB::table('input_types')->where('key', $value)->exists();
        if ($existsInDb) {
            return;
        }

        //  3. not found in Enum nor DB
        $fail(trans('validation.exists', ['attribute' => $attribute]));
    }
}
