<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pictures';

    protected $fillable = [
        'album_id',
        'picture',
    ];

    protected $dates = ['deleted_at'];

    const MAX_FILES_UPLOAD = 10;

}
