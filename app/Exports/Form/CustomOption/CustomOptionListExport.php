<?php

namespace App\Exports\Form\CustomOption;

use App\Exports\BaseExport;

class CustomOptionListExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($option) {
            $name = is_string($option->title) && json_validate($option->title)
                ? json_decode($option->title, true)
                : [];

            return [
                'Name (EN)' => $name['en'] ?? '',
                'Name (AR)' => $name['ar'] ?? '',
                'Key' => $option->key,
                'Is Default' => $option->is_default ? 'Yes' : 'No',
                'Is Active' => $option->is_active ? 'Yes' : 'No',
                'Created By' => $option->createdBy?->name ?? '',
                'Updated By' => $option->updatedBy?->name ?? '',
                'Created At' => $option->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $option->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'custom_options.xlsx');
    }
}
