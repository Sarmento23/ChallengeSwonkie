<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    public $timestamps = false;
    protected $table = 'Videos';

    protected $fillable = [
        'id',
        'title',
        'thumbnail',
        'description',
        'idYoutuber',
        'url',
        'publishedAt',
        'updatedAt'
    ];

    protected $primaryKey = 'id';
    protected $keyType='string';
}


?>