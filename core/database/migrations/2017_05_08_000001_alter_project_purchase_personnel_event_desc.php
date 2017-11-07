<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProjectPurchasePersonnelEventDesc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_purchase', function ($table) {
            $table->string('personnel', 500)->change();
            $table->string('event_desc', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_purchase', function ($table) {
            $table->string('personnel', 255)->change();
            $table->string('event_desc', 255)->change();
        });
    }
}
