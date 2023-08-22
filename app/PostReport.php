<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostReport extends Model {

    use SoftDeletes;

    protected $table = "post_report";
    protected $fillable = [
        'post_id',
        'user_id',
        'type',
        'report_type'
    ];

}
