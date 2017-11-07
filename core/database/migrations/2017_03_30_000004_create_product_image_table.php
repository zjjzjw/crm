<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('product_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->default(0)->comment('产品ID');
            $table->integer('image_id')->default(0)->comment('图片ID');
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
        Schema::drop('product_image');
    }
}
