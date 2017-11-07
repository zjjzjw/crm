<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAimHinderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_aim_hinder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->default(0)->comment('项目ID');
            $table->integer('aim_id')->default(0)->comment('目标ID');
            $table->string('hinder_name', 255)->default('')->comment('障碍名称');
            $table->string('implementation_plan', 255)->default('')->comment('实施计划');
            $table->integer('project_purchase_id')->default(0)->commet('采购流程ID');
            $table->string('feedback', 255)->default('')->comment('结构反馈');
            $table->string('resource_application')->default('')->comment('资源申请');
            $table->timestamp('executed_at')->default('0000-00-00 00:00:00')->comment('执行时间');
            $table->tinyInteger('status')->default(0)->comment('1:待审核,2:审核通过,3:审核驳回');
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
        Schema::drop('project_aim_hinder');
    }
}
