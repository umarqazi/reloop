<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('type');
            $table->integer('amount');
            $table->integer('max_usage_per_user');
            $table->integer('max_usage_limit');
            $table->enum('apply_for_user', ['1', '2'])->default('1');
            $table->enum('coupon_user_type', ['1', '2', '3'])->default('3');
            $table->integer('list_user_id')->nullable();
            $table->enum('apply_for_category', ['1', '2'])->default('1');
            $table->enum('coupon_category_type', ['1', '2', '3'])->default('3');
            $table->integer('list_category_id')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
