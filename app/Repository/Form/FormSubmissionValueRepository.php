<?php

namespace App\Repository\Form;

use App\Models\Form\FormSubmissionValue;
use App\Repository\MainRepository;

class FormSubmissionValueRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return FormSubmissionValue::class;
    }


    /**
     * @param int $formSubmissionId
     * @param array $inputs
     * @return mixed
     */
    public function storeSubmissionValue(int $formSubmissionId, array $inputs): mixed
    {
        $data = [];

        foreach ($inputs as $input) {
            $isEntity = isset($input['value']['entity']);
            $data[] = [
                'form_submission_id' => $formSubmissionId,
                'template_input_id' => $input['templateInputId'],
                'value' => $isEntity
                    ? $input['value']['value']
                    : json_encode(["value" => $input['value']]),

                'input_key' => $input['inputKey'] ?? null,
                'is_default' => $input['isDefault'] ?? 0,
                'type_entity' => $isEntity
                    ? $input['value']['entity']
                    : null,
            ];
        }

        return $this->model::insert($data);
    }


    /**
     * @param int $formSubmissionId
     * @param array $inputs
     * @return mixed
     */
    public function updateSubmissionValue(int $formSubmissionId, array $inputs): mixed
    {
        $this->model::where('form_submission_id', $formSubmissionId)->delete();

        // $data = [];
        // foreach ($inputs as $input) {
        //     $isEntity = isset($input['value']['entity']);
        //     $data[] = [
        //         'form_submission_id' => $formSubmissionId,
        //         'template_input_id' => $input['templateInputId'],
        //         'value' => $isEntity
        //             ? $input['value']['value']
        //             : json_encode(["value" => $input['value']]),
        //         "input_key" => $input["inputKey"],
        //         "is_default" => $input['isDefault'] ?? 0,
        //     ];
        // }

        // return $this->model::insert($data);
        return $this->storeSubmissionValue($formSubmissionId, $inputs);
    }
}
