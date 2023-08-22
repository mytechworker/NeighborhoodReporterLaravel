<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureBusiness extends Model {

    use SoftDeletes;

    protected $table = "feature_business";
    protected $fillable = ['user_id', 'business_name', 'location', 'town', 'zip', 'message_to_reader', 'phone', 'website', 'address', 'image', 'business_report'];

}
