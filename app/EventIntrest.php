<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventIntrest extends Model {

    protected $table = "event_interested";
    protected $fillable = [
        'event_id',
        'user_id'
    ];

}
