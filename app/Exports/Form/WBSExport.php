<?php

namespace App\Exports\Form;

use App\Exports\BaseExport;

class WBSExport extends BaseExport
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
        $flat = collect();
        foreach ($collection as $wbs) {
            $this->flatten($wbs, $flat);
        }

        parent::__construct($flat, $fileName ?? 'WBS.xlsx');
    }

    /**
     * Recursively flatten WBS with children
     *
     * @param  mixed $wbs
     * @param  \Illuminate\Support\Collection $flat
     * @param  int|null $parentId
     * @return void
     */
    protected function flatten($wbs, &$flat, $parentId = null)
    {
        $title = json_validate($wbs->title) ? json_decode($wbs->title, true) : [];

        $flat->push([
            'Title (EN)' => $title['en'] ?? '',
            'Title (AR)' => $title['ar'] ?? '',
            'Has Parent' => $parentId?true:false,
            'Created By' => $wbs->createdBy?->name ?? '',
            'Updated By' => $wbs->updatedBy?->name ?? '',
            'Created At' => $wbs->created_at?->format('Y-m-d H:i:s'),
            'Updated At' => $wbs->updated_at?->format('Y-m-d H:i:s'),
        ]);

        foreach ($wbs->chiles ?? [] as $child) {
            $this->flatten($child, $flat, $wbs->id);
        }
    }
}
