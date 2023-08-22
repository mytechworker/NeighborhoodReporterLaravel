<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClasifiedComment extends Model {

    use SoftDeletes;

    protected $fillable = [
        'classified_id',
        'user_id',
        'parent_id',
        'description',
        'like_count',
        'image'
    ];
    protected $table = 'classified_comments';
    protected $dates = ['deleted_at'];

}
