<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');

            $table->text('location');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('type')->nullable();
            $table->integer('no_of_bedrooms')->nullable();
            $table->string('building_name')->nullable();
            $table->string('address_name')->nullable();
            $table->integer('no_of_occupants')->nullable();
            $table->string('street')->nullable();
            $table->string('floor')->nullable();
            $table->string('unit_number')->nullable();
            $table->boolean('default');
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
        Schema::dropIfExists('addresses');
    }
}
