<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFileCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_file_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_file_id')->default(0)->comment('项目ID');
            $table->string('comment', 255)->default('')->comment('评价');
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
        Schema::drop('project_file_comment');
    }
}
