<?php

namespace App\Repository\InputForm;

use App\Models\InputForm\PrintInput;
use App\Repository\MainRepository;

class PrintInputRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return PrintInput::class;
    }

}

