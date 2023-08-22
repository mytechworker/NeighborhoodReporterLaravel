<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventComment extends Model {

    use SoftDeletes;

    protected $fillable = [
        'event_id',
        'user_id',
        'parent_id',
        'description',
        'like_count',
        'image'
    ];
    protected $table = 'event_comments';
    protected $dates = ['deleted_at'];

}
