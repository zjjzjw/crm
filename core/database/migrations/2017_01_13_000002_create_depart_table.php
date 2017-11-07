<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->default(0)->comment('公司ID');
            $table->bigInteger('parent_id')->default(0)->comment('父ID');
            $table->string('name', 50)->default('')->comment('部门名称');
            $table->string('desc')->default('')->copmment('描述');
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
        Schema::drop('depart');
    }
}
