<?php

namespace App\Repository\InputForm;

use App\Models\InputForm\TemplateInput;
use App\Repository\MainRepository;

class InputFormRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return TemplateInput::class;
    }

}
