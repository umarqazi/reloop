<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('organizations')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('stripe_customer_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('hh_organization_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('player_id')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('user_type')->nullable();
            $table->tinyInteger('login_type')->nullable();
            $table->integer('trips')->nullable();
            $table->integer('reward_points')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('reports')->default(true);
            $table->timestamp('verified_at')->nullable();
            $table->string('password_reset_token')->nullable();
            $table->string('signup_token')->nullable();
            $table->string('api_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
