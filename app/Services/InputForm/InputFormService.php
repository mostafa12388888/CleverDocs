<?php

namespace App\Services\InputForm;

use App\Repository\InputForm\InputFormRepository;
use App\Repository\MainRepository;
use App\Services\Form\InputTypeService;
use App\Services\MainService;
use Throwable;
use Illuminate\Support\Str;

class InputFormService extends MainService
{
    /**
     * @var InputFormRepository
     */
    protected MainRepository $repository;

    /**
     * @param InputFormRepository $repository
     */
    public function __construct(InputFormRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    /**
     * @param int $formId
     * @param array $inputs
     * @throws Throwable
     */
    public function addFormInputs(int $formId, array $inputs)
    {
        $data = [];
        foreach ($inputs as $input) {
            $webFormat = $input['webFormat'];
            $printFormat = $input['printFormat'];
            $titleRepo=app(InputTypeService::class)->find($input['inputTypeId']);
            //@TODO: Merge both in same Schema and use Bulk Insert
            $data[] = [
                'input_types_id' => $input['inputTypeId'],
                'templates_forms_id' => $formId,
                'width' => $webFormat['width'],
                'height' => $webFormat['height'],
                'position_y' => $webFormat['y'],
                'position_x' => $webFormat['x'],
                'tooltip' => $webFormat['tooltip']??null,
                'placeholder' => $webFormat['placeholder']??null,
                'title' => json_encode($titleRepo->title),
                'is_mandatory' => $webFormat['isMandatory'] ?? true, 
                'styles' => json_encode([
                    'inputStyles' => $webFormat['inputStyles'] ?? [],
                    'labelStyles' => $webFormat['labelStyles'] ?? [],
                    'borderStyles' => $webFormat['borderStyles'] ?? [],
                ]),
                "uuid"=> Str::uuid(),
                'print_details' => json_encode([
                    'width' => $printFormat['width'],
                    'height' => $printFormat['height'],
                    'positionX' => $printFormat['x'],
                    'positionY' => $printFormat['y'],
                    'hide' => $printFormat['hide']??0,
                    'styles' => [
                        "inputStyles" => $printFormat['inputStyles'] ?? [],
                        "labelStyles" => $printFormat['labelStyles'] ?? [],
                        "borderStyles" => $printFormat['borderStyles'] ?? [],
                        ]
                ])
            ];
        }

        $this->insert($data);
    }

}

