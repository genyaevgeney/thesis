<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('enterprise_day_id');
            $table->foreign('enterprise_day_id')->references('id')->on('enterprise_days');
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->double('humidity');
            $table->double('temperature');
            $table->double('drum_speed');
            $table->double('processed_carbon');
            $table->double('first_zone_fuel');
            $table->double('second_zone_fuel');
            $table->double('third_zone_gas');
            $table->double('burner_gas');
            $table->double('drum_drive_energy');
            $table->double('first_compressor_energy');
            $table->double('second_compressor_energy');
            $table->double('third_compressor_energy');
            $table->double('additional_functions_energy');
            $table->double('water_solution');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->
                default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensors');
    }
}
