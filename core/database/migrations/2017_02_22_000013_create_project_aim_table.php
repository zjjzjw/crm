<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_aim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->default(0)->comment('项目ID');
            $table->string('name', 255)->default('')->comment('目标名称');
            $table->integer('product_id')->default(0)->comment('产品ID');
            $table->decimal('price', 10, 2)->default(0)->comment('价格');
            $table->integer('volume')->default(0)->comment('体量');
            $table->string('pain_analysis')->default('')->comment('通点分析');
            $table->string('other', 255)->default(0)->comment('其他');
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
        Schema::drop('project_aim');
    }
}
