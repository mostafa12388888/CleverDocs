<?php

namespace App\Enum\Form;

use App\Enum\Enum;

class PrivateInBoxTypeProjectRequiredEnum extends Enum
{
    const SUBMISSION = 'submission';
    const DISTRIBUTION = 'distribution';
    const WORKFLOW = 'workflow';
    const PROJECT = 'project';
}
