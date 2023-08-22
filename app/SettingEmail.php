<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingEmail extends Model
{
    use SoftDeletes;
    protected $table = "setting_email";

    protected $fillable = [
        'user_id',
        'community_id',
        'Daily_news',
        'breacking_news',
        'community_cal',
        'neighbor_posts',
        'classifieds',
    ];
}
