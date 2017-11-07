<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->default(0)->comment('公司ID,或者是竞品公司ID');
            $table->integer('category_id')->default(0)->comment('产品分类');
            $table->tinyInteger('ascription')->default(0)->commnet('归属类型');
            $table->integer('ascription_id')->default(0)->commnet('归属公司ID');
            $table->string('name', 50)->default('')->comment('产品名称');
            $table->decimal('price', 11, 2)->default(0)->comment('产品价格');
            $table->text('attribfield')->default('')->comment('产品参数');
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
        Schema::drop('product');
    }
}
