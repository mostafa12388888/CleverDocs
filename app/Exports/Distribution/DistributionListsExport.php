<?php

namespace App\Exports\Distribution;

use App\Exports\BaseExport;

class DistributionListsExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($distribution) {
            return [
                'Is Active' => $distribution->is_active ? 'Yes' : 'No',
                'Title (EN)' => $distribution->title['en'] ?? '',
                'Title (AR)' => $distribution->title['ar'] ?? '',
                'Created By' => $distribution->createdBy?->name ?? '',
                'Updated By' => $distribution->updatedBy?->name ?? '',
                'Created At' => $distribution->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $distribution->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'distributions.xlsx');
    }
}
