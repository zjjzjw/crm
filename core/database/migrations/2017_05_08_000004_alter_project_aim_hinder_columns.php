<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProjectAimHinderColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_aim_hinder', function ($table) {
            $table->string('hinder_name', 500)->change();
            $table->string('implementation_plan', 500)->change();
            $table->string('resource_application', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_aim_hinder', function ($table) {
            $table->string('hinder_name', 255)->change();
            $table->string('implementation_plan', 255)->change();
            $table->string('resource_application', 255)->change();
        });
    }
}
