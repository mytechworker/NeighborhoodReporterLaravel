<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends Model
{
    use SoftDeletes;
    protected $table="faq_categories";

    protected $fillable=['title','description'];

    protected $dates = ['deleted_at'];
}
