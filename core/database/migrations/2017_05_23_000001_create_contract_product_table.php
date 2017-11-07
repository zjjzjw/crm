<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->default(0)->comment('合同ID');
            $table->integer('product_id')->default(0)->comment('产品ID');
            $table->integer('product_number')->default(0)->comment('产品数量');
            $table->decimal('product_price', 11, 2)->default(0)->comment('产品价格');
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
        Schema::drop('contract_product');
    }
}
