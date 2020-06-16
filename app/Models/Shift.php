<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shifts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'line_id',
        'name',
        'time_begin',
        'time_end'
    ];
}
