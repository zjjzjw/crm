<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAnalyseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_analyse', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->default(0)->comment('项目ID');
            $table->string('event_desc')->default('')->comment('事件描述');
            $table->integer('analyse_type')->default(0)->comment('优劣势类别');
            $table->integer('swot_type')->default(0)->comment('优劣势类型');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_analyse');
    }
}
