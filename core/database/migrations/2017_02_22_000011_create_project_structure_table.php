<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectStructureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_structure', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->comment('父节点');
            $table->integer('project_id')->default(0)->comment('项目ID');
            $table->string('name', 50)->default('')->comment('人物名称');
            $table->string('position_name', 50)->default('')->comment('职位名称');
            $table->string('contact_phone', 50)->default('')->comment('联系方式');
            $table->integer('structure_role_id')->default(0)->comment('角色');
            $table->integer('current_related_id')->default(0)->comment('现阶段关系');
            $table->string('character', 255)->default('')->comment('性格');
            $table->string('interest', 255)->default('')->comment('兴趣');
            $table->string('breakthrough_plan', 255)->default('')->comment('突破计划');
            $table->tinyInteger('feedback')->default(0)->comment('结果反馈 1成功 2失败');
            $table->string('proof', 255)->default('')->comment('举证');
            $table->string('pain_desc', 255)->default('')->comment('痛苦描述');
            $table->tinyInteger('support_type')->default(0)->comment('支持类型');
            $table->tinyInteger('structure_type')->default(0)->comment('结构类型 1:项目 2:客户');
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
        Schema::drop('project_structure');
    }
}
