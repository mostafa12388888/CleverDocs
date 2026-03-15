<?php

namespace App\Repository;


use App\Models\Fileable;

class FileableRepository extends MainRepository
{
    /**
     * @inheritDoc
     */
    public function model(): string
    {
        return Fileable::class;
    }




}
