<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributeToMaterialCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_categories', function (Blueprint $table) {
            $table->integer('quantity')->after('status');
            $table->tinyInteger('unit')->after('quantity');
            $table->integer('reward_points')->after('unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_categories', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('unit');
            $table->dropColumn('reward_points');
        });
    }
}
