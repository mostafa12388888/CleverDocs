<?php

namespace App\Http\Resources\Form\Storeandupdate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreTempalteFormandInputAndPrint extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Storeandupdate'=>$this-> Storeandupdate,
            'width'=>$this->width,
            'height'=>$this-> height,
            'positionY'=>$this-> y,
            'positionX'=>$this-> x,
            'updateDate'=>$this-> inputId,
            'status'=>$this-> status,
            'Primary'=>$this->Primary,
            'layout'=>$this->layout,
            'nameAr'=>$this->nameAr,
            'nameEn'=>$this->nameEn,
            'titlePosition'=>$this->titlePosition,
            'templateInputId'=>$this->templateInputId,
            'templatesFormId'=>$this->templatesFormId,
            'styleStyleLine'=>$this->styleStyleLine,
            'styleStyleFill'=>$this->styleStyleFill,
            'styleSizeLine'=>$this->styleSizeLine,
            'textItalic'=>$this->textItalic,
            'textZoom'=>$this->textZoom,
            'textVertical'=>$this->textVertical,
            'textPositionLineY'=>$this->textPositionLineY,
            'textPositionLineX'=>$this->textPositionLineX,
            'textPosition'=>$this->textPosition,
            'textWritingDirection'=>$this->textWritingDirection,
            'textFontColor'=>$this->textFontColor,
            'titleBold'=>$this->titleBold,
            'titleItalic'=>$this->titleItalic,
            'titleUnderline'=>$this->titleUnderline,
            'titleVertical'=>$this->titleVertical,
            'titleZoom'=>$this->titleZoom,
            'titlePositionLineY'=>$this->titlePositionLineY,
            'titlePositionLineX'=>$this->titlePositionLineX,
            'titlePosition'=>$this->titlePosition,
            'titleWritingDirection'=>$this->titleWritingDirection,
            'titleFontColor'=>$this->titleFontColor,

        ];
    }
}
