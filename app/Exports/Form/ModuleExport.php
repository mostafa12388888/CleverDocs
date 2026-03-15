<?php

namespace App\Exports\Form;

use App\Exports\BaseExport;

class ModuleExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($module) {
            return [
                'Name' => $module->name,
                'Order' => $module->order,
                'Created By' => $module->createdBy?->name ?? '',
                'Updated By' => $module->updatedBy?->name ?? '',
                'Created At' => $module->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $module->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'modules.xlsx');
    }
}
