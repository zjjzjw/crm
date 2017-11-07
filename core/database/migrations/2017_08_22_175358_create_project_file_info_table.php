<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFileInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_file_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_file_id')->default(0)->comment('档案ID');
            $table->string('file_model', 255)->default('')->comment('型号');
            $table->decimal('price', 10, 2)->default(0)->comment('价格');
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
        Schema::drop('project_file_info');
    }
}
