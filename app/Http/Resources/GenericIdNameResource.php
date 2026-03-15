<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenericIdNameResource extends JsonResource
{

    private static $columns = [];

    public static function setColumns($columns){
        self::$columns = $columns;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $columns = self::$columns;
        $data = [];
        foreach ($columns as $column){
            $data[$column['viewKey']] =  $this->{$column['modelKey']};
        }
        return $data;
    }
}
