<?php

namespace App\Exports\Form;

use App\Exports\BaseExport;

class MainTemplateFormExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($mainForm) {
            $form = $mainForm->lastVersion;

            $name = is_string($form->name) && json_validate($form->name)
                ? json_decode($form->name, true)
                : [];

            return [
                'Version' => $form->version ?? '',
                'Name (EN)' => $name['en'] ?? '',
                'Name (AR)' => $name['ar'] ?? '',
                'Status' => $form->status ?? '',
                'Primary' => $form->Primary ? 'Yes' : 'No',
                'Layout' => $form->layout ?? '',
                'Symbol' => $form->symbol ?? '',
                'Created By' => $form->createdBy?->name ?? '',
                'Updated By' => $form->updatedBy?->name ?? '',
                'Created At' => $form->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $form->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'main-forms.xlsx');
    }
}
