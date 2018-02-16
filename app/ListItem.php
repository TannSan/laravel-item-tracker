<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents a single list item.
 */
class ListItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'parent_id',
        'user_id',
        'label'
    ];
}
