<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

    use SoftDeletes;

    protected $table = "post";
    protected $fillable = [
        'post_author',
        'post_date',
        'location',
        'town',
        'zip',
        'post_title',
        'post_subtitle',
        'post_content',
        'post_image',
        'post_category',
        'post_type',
        'post_status',
        'guid',
        'like_count',
        'comment_count',
        'post_report'
    ];

    protected $casts = [
        'post_date' => 'datetime:M d, Y h:i A',
    ];

}
