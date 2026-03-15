<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fileable extends BaseModel
{
    use HasFactory;

    protected $table = 'fileables';

    protected $fillable = [
        'file_id', 'fileable_id', 'fileable_type'
    ];

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }


}
