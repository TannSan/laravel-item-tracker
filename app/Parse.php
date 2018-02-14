<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parse extends Model
{
    protected $fillable = [
        'member_name',
        'forum_link',
        'parse_link',
        'parse_date',
        'parse_dps',
        'advanced_class',
        'specialization',
        'is_crazy'
    ];
}
