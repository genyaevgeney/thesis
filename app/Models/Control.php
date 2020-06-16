<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'controls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enterprise_day_id',
        'shift_id',
        'mark',
        'humidity',
        'specific_surface_area',
        'iodine_number',
        'oil_absorption',
        'bulk_density',
        'granule_size',
        'abrasion_resistance',
        'drum_outlet_temperature'
    ];
}
