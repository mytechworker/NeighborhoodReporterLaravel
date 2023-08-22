<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Communitie extends Model
{
    use SoftDeletes;
    protected $table="communities";

    protected $fillable=['region_id','name','status'];

    protected $dates = ['deleted_at'];  

    public static $status=[
        'Active' => 'Active',
        'Inactive' => 'Inactive'
    ];

    public function region()
    {
        return $this->belongsTo('App\Region');
    }
}
