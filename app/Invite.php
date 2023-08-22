<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invite extends Model
{
    use SoftDeletes;
    protected $table = "invites";
    protected $fillable=['friend_name','friend_email','your_name'];
}
