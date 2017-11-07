<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_purchase', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->default(0)->comment('项目ID');
            $table->string('name', 50)->default('')->comment('名称');
            $table->string('personnel', 255)->default('')->comment('人员');
            $table->timestamp('timed_at')->default('0000-00-00 00:00:00')->comment('时间');
            $table->string('event_desc')->default('')->comment('事件');
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
        Schema::drop('project_purchase');
    }
}
