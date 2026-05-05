<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ApiResource]
class CreatorFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'original_filename',
        'file_path',
        'file_type',
        'software',
        'file_size',
        'description',
        'download_count',
    ];
}
