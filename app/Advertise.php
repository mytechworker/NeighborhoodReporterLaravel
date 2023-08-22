<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertise extends Model
{
    use SoftDeletes;
    protected $table="advertises";

    protected $fillable=['business_name','zip_code','first_name','last_name','email','phone_no','advertising_goal','about_your_business','status'];

    public static $status=[
        'Active' => 'Active',
        'Inactive' => 'Inactive'
    ];
}
