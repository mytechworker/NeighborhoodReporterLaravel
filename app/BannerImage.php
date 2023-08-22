<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerImage extends Model
{
    use SoftDeletes;
    protected $table="banner_images";
    protected $fillable=['page_name','page_slug','image'];
}
