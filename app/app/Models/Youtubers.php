<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

Class Youtubers extends Model
{
    public $timestamps = false;
    protected $table = 'Youtuber';

    protected $fillable = [
        'id',
        'name',
        'description',
        'nrSubs',
        'createdAt'
    ];

    protected $primaryKey = 'id';
    protected $keyType='string';

}

?>