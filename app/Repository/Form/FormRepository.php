<?php

namespace App\Repository\Form;

use App\Http\Filters\Filter;
use App\Models\Form\TemplatesForm;
use App\Repository\MainRepository;

class FormRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return TemplatesForm::class;
    }


    /**
     * @param int $mainTemplateId
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function allVersions(int $mainTemplateId, int $page, int $perPage, Filter $filter): mixed
    {
        $query = $this->model->select(['templates_forms.*'])->with("updatedBy","createdBy","submissions");
        if ($filter) {
            $query = $filter->apply($query);
        }
        return $query->byMainTemplateId($mainTemplateId)->latest()->paginate($perPage, '*', 'page', $page);
    }
}

