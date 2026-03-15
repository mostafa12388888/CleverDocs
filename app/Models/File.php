<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class File extends BaseModel
{
    use HasFactory;


    protected $table = 'files';

    protected $fillable = [
        'original_name', 'stored_name', 'path', 'mime_type', 'size', 'extension'
    ];


    /**
     * @return MorphToMany
     */
    public function fileables(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable');
    }
}
