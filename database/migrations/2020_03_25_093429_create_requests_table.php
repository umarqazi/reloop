<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('request_number');
            $table->boolean('confirm')->default('0');
            $table->tinyInteger('driver_trip_status')->default('1');
            $table->date('collection_date');
            $table->tinyInteger('collection_type')->nullable();
            $table->double('reward_points')->nullable();
            $table->tinyInteger('status')->default(1);

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('phone_number');
            $table->string('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('city');
            $table->string('district');
            $table->string('street');

            $table->string('question_1');
            $table->string('answer_1');
            $table->string('question_2');
            $table->string('answer_2');
            $table->text('additional_comments')->nullable();
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
        Schema::dropIfExists('requests');
    }
}
