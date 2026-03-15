<?php

namespace App\Enum\Form;

use App\Enum\Enum;

class PrivateInBoxTypeEnum extends Enum
{
    const SUBMISSION = 'submission';
    const PROJECT = 'project';
    const COMPANY = 'company';
    const WORKFLOW = 'workflow';
    const DISTRIBUTION = 'distribution';
    const FORM='form';
}
