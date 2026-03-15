<?php

namespace App\Exports\Workflow;

use App\Exports\BaseExport;

class MainWorkFlowExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($workflow) {
            $wf = $workflow->lastVersion ?? $workflow;

            $title = json_validate($wf->title) ? json_decode($wf->title, true) : [];

            return [
                'Main Workflow ID' => $wf->main_workflow_id,
                'Title (EN)' => $title['en'] ?? '',
                'Title (AR)' => $title['ar'] ?? '',
                'SLA Value' => $wf->sla_value,
                'SLA Type' => $wf->sla_unit,
                'Is Auto Close' => $wf->is_auto_close ? 'Yes' : 'No',
                'Is Active' => $wf->is_active ? 'Yes' : 'No',
                'Created By' => $wf->createdBy?->name ?? '',
                'Updated By' => $wf->updatedBy?->name ?? '',
                'Created At' => $wf->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $wf->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'workflows.xlsx');
    }
}
