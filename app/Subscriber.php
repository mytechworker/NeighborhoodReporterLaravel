<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model {

    use SoftDeletes;

    protected $table = "subscriber";
    protected $fillable = ['email', 'location_id', 'type','status'];

}
