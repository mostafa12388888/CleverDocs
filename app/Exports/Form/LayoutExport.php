<?php

namespace App\Exports\Form;

use App\Exports\BaseExport;

class LayoutExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($layout) {
            $subject = is_string($layout->subject) && json_validate($layout->subject)
                ? json_decode($layout->subject, true)
                : [];

            return [
                'Subject (EN)' => $subject['en'] ?? '',
                'Subject (AR)' => $subject['ar'] ?? '',
                'Type' => $layout->type,
                'Module ID' => $layout->module_id,
                'Project ID' => $layout->project_id,
                'Status' => $layout->status,
                'Created By' => $layout->user?->contact?->name['en'] ?? '',
                'Updated By' => $layout->updatedBy?->contact?->name['en'] ?? '',
                'Created At' => $layout->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $layout->updated_at?->format('Y-m-d H:i:s'),
                'Image URL' => $layout->imageFile?->file_path ?? '',
            ];
        });

        parent::__construct($mapped, $fileName ?? 'layouts.xlsx');
    }
}
