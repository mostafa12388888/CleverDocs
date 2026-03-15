<?php

namespace App\Enum\Form;

use App\Enum\Enum;

class InputTypeCategoryEnum extends Enum
{
    const NUMBER = 'number';
    const TEXT = 'text';
    const DATE_AND_TIME = 'date_and_time';
    const DATE = 'date';
    const SELECTION = 'selections';
    const OFFICIAL_SIGNATURE = 'official_signatures';
    const SPECIAL_INPUT = 'specials';
    const TABLE = 'table';

}
