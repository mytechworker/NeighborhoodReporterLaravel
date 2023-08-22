<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classified extends Model {

    use SoftDeletes;

    protected $table = "classified";
    protected $fillable = [
        'user_id',
        'location',
        'town',
        'category',
        'title',
        'description',
        'image',
        'like_count',
        'comment_count'
    ];

}
