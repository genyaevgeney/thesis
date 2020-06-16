<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensors';

    protected $fillable = [
        'enterprise_day_id',
        'shift_id',
        'humidity',
        'temperature',
        'drum_speed',
        'processed_carbon',
        'first_zone_fuel',
        'second_zone_fuel',
        'third_zone_gas',
        'burner_gas',
        'drum_drive_energy',
        'first_compressor_energy',
        'second_compressor_energy',
        'third_compressor_energy',
        'additional_functions_energy',
        'water_solution'
    ];
}
