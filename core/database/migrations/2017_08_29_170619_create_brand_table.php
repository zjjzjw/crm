<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('company_id')->default(0)->comment('公司ID');
            $table->string('company_name')->default('')->comment('品牌公司名称');
            $table->string('brand_name')->default('')->comment('品牌名称');
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
        Schema::drop('brand');
    }
}
