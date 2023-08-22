<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClasifiedContact extends Model {

    use SoftDeletes;

    protected $fillable = [
        'classified_id',
        'email',
        'description'
    ];
    protected $table = 'classified_contacts';
    protected $dates = ['deleted_at'];

}
