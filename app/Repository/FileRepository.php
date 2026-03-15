<?php

namespace App\Repository;


use App\Models\File;

class FileRepository extends MainRepository
{
    /**
     * @inheritDoc
     */
    public function model(): string
    {
        return File::class;
    }


}
