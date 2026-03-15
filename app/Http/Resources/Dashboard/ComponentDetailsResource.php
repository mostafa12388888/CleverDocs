<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComponentDetailsResource extends JsonResource
{
    protected $statistics;

    public function __construct($resource, $statistics)
    {
        parent::__construct($resource);
        $this->statistics = $statistics;
    }

    public function toArray(Request $request): array
    {
        $colors = $this->color_record;
        if (is_string($colors)) {
            $decoded = json_decode($colors, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $colors = $decoded;
            }
        }
        if (!is_array($colors)) {
            $colors = [];
        }

        return [
            "id" => $this->id,
            "title" => $this->title,
            "colorRecord" => $colors,
            "formId" => $this->form_id,
            "dashboardId" => $this->dashboard_id,
            "chartType" => $this->chart_type,
            "countBy" => $this->count_by,
            "groupBy" => $this->count_by,
            "isPrivate" => $this->is_private,
            "createdBy" => CreatedByInfo::make($this->createdBy),
            "updatedBy" => CreatedByInfo::make($this->updatedBy),
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "filters" => ComponentFilterSubmissionResource::make($this->filter),
            "statistics" => collect($this->statistics)->mapWithKeys(function ($items, $groupIndex) use ($colors) {
                // groupBy case
                if (isset($items[0]) && is_array($items[0])) {
                    $key = json_decode($groupIndex, true)['value'] ?? $groupIndex;

                    return [
                        $key => collect($items)->map(function ($item, $index) use ($colors) {
                            return array_merge((array) $item, [
                                "title" => json_decode($item['title']),
                                "color" => $colors[$index] ?? null,
                            ]);
                        })->toArray()
                    ];
                }

                // countBy only
                $key = json_decode($items->title, true) ?? $items->title;

                return [
                        array_merge($items->toArray(), [
                            "title" => json_decode($items->title),
                            "color" => $colors[$groupIndex] ?? null,
                        ])
                ];
            }),
        ];
    }
}
