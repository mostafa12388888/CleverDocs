<?php

namespace App\Repository\Communication;

use App\Http\Filters\Filter;
use App\Models\Email;
use App\Repository\MainRepository;

class MailRepository extends MainRepository
{


    /**
     * @return string
     */
    public function model(): string
    {
        return Email::class;
    }
    public function index(int $page, int $perPage,?string $type='' ,?Filter $filter=null): mixed
    {
        $query=$this->model;
        if ($filter)  $query = $query->filter($filter);
        return $query->where("type",$type)->with("ccRecipients","toRecipients","createdBy")->paginate($perPage, ['*'], 'page', $page);
    }
}

