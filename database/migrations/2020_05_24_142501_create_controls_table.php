<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('enterprise_day_id');
            $table->foreign('enterprise_day_id')->references('id')->on('enterprise_days');
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->string('mark');
            $table->double('humidity');
            $table->double('specific_surface_area');
            $table->double('iodine_number');
            $table->double('oil_absorption');
            $table->double('bulk_density');
            $table->double('granule_size');
            $table->double('abrasion_resistance');
            $table->double('drum_outlet_temperature');
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
        Schema::dropIfExists('controls');
    }
}
