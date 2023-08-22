<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model {

    use SoftDeletes;

    protected $table = "event";
    protected $fillable = [
        'user_id',
        'location',
        'town',
        'date',
        'time',
        'am_pm',
        'venue',
        'title',
        'description',
        'link',
        'image'
    ];

}
