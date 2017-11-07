<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyVerifyBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_verify_brand', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id')->default(0)->comment('品牌ID');
            $table->integer('sale_property_id')->default(0)->comment('楼盘数据ID');
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
        Schema::drop('property_verify_brand');
    }
}
