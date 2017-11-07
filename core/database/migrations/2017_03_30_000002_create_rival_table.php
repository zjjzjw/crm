<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRivalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rival', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->default(0)->comment('公司ID');
            $table->string('name', 50)->default('')->comment('产品分类名称');
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
        Schema::drop('rival');
    }
}
