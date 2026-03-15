<?php

namespace App\Exports\Form;

use App\Exports\BaseExport;

class ProjectExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($project) {
            $name = json_validate($project->name) ? json_decode($project->name, true) : [];
            $wbsTitle = $project->wbs?->title;
            $wbs = json_validate($wbsTitle) ? json_decode($wbsTitle, true) : [];

            return [
                'User Assign ID' => $project->user_id,
                'Name (EN)' => $name['en'] ?? '',
                'Name (AR)' => $name['ar'] ?? '',
                'Description' => $project->description,
                'Company Name' => $project->company?->name ?? '',
                'Contact Name (EN)' => $project->contact?->name['en'] ?? '',
                'Contact Name (AR)' => $project->contact?->name['ar'] ?? '',
                'Reference No' => $project->reference_number,
                'Status' => $project->status,
                'Project Type' => $project->inputOption?->title['en'] ?? '',
                'Country' => $project->country?->title['en'] ?? '',
                'Contract Value' => $project->contract_value,
                'Order' => $project->order,
                'WBS Title (EN)' => $wbs['en'] ?? '',
                'WBS Title (AR)' => $wbs['ar'] ?? '',
                'Logo URL' => $project->logoFile?->file_path ?? '',
                'Created By' => $project->createdBy?->name ?? '',
                'Updated By' => $project->updatedBy?->name ?? '',
                'Created At' => $project->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $project->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'projects.xlsx');
    }
}
