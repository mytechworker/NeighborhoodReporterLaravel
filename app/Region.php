<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;
    protected $table="regions";

    protected $fillable=['region_code','name','status'];

    protected $dates = ['deleted_at'];

    public static $status=[
        'Active' => 'Active',
        'Inactive' => 'Inactive'
    ];

    public function communitie()
    {
        return $this->hasOne('App\Communitie');
    }
}
