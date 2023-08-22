<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;
    protected $table="faqs";

    protected $fillable=['faq_category_id','title','description'];

    protected $dates = ['deleted_at'];
}
