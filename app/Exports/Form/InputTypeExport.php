<?php

namespace App\Exports\Form;

use App\Exports\BaseExport;

class InputTypeExport extends BaseExport
{

    /**
     * __construct
     *
     * @param  mixed $collection
     * @param  mixed $fileName
     * @return void
     */
    public function __construct($collection, string $fileName = null)
    {
        $mapped = collect($collection)->map(function ($inputType) {
            return [
                'Title (EN)' => $inputType->title['en'] ?? '',
                'Title (AR)' => $inputType->title['ar'] ?? '',
                'Type' => $inputType->type,
                'Key' => $inputType->key,
                'Custom List ID' => $inputType->custom_option_list_id,
                'Entity' => $inputType->entity,
                'Options Type' => $inputType->options_type,
                'Created By' => $inputType->createdBy?->name ?? '',
                'Updated By' => $inputType->updatedBy?->name ?? '',
                'Created At' => $inputType->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $inputType->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'input-types.xlsx');
    }
}
