<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAimProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_aim_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_aim_id')->default(0)->comment('目标ID');
            $table->integer('product_id')->default(0)->comment('产品ID');
            $table->integer('volume')->default(0)->comment('产品体量');
            $table->decimal('price', 11, 2)->default(0)->comment('产品价格');
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
        Schema::drop('project_aim_product');
    }
}
