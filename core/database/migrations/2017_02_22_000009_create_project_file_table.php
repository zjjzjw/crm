<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_file', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->default(0)->comment('项目ID');
            $table->string('history_brands', 255)->default('')->comment('历史合作品牌');
            $table->string('file_model', 255)->default('')->comment('型号');
            $table->decimal('price', 10, 2)->default(0)->comment('价格');
            $table->string('cooperation_brands', 255)->default('')->comment('参与品牌');
            $table->string('evaluate', 255)->default('')->comment('评价');
            $table->string('bench_brands', 255)->default('')->comment('楼盘对标品牌');
            $table->string('tender_reason', 255)->default('')->comment('招标原因');
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
        Schema::drop('project_file');
    }
}
