<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PressRelease extends Model
{
    use SoftDeletes;
    protected $table="press_releases";

    protected $fillable=['title','date','external_link'];

    protected $dates = ['deleted_at'];
}
