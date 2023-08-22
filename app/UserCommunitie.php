<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCommunitie extends Model
{
    use SoftDeletes;
    protected $table="user_communities";

    protected $fillable=['user_id','communitie_id','default'];

    protected $dates = ['deleted_at'];
}
