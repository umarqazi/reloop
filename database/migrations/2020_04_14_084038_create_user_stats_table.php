<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stats', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('request_collection_id');
            $table->foreign('request_collection_id')->references('id')->on('request_collections')->onUpdate('cascade')
                ->onDelete('cascade');

            $table->double('co2_emission_reduced');
            $table->double('trees_saved');
            $table->double('oil_saved');
            $table->double('electricity_saved');
            $table->double('natural_ores_saved');
            $table->double('water_saved');
            $table->double('landfill_space_saved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_stats');
    }
}
