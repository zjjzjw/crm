<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->bigInteger('company_id')->default(0)->comment('公司ID');
            $table->string('contract_number')->default('')->comment('合同编号');
            $table->string('contract_name')->default('')->comment('合同名称');
            $table->integer('customer_id')->default(0)->comment('客户ID');
            $table->integer('product_id')->default(0)->comment('产品ID');
            $table->integer('product_number')->default(0)->comment('产品数量');
            $table->decimal('product_price', 11, 2)->default(0)->comment('产品价格');
            $table->decimal('contract_amount', 11, 2)->default(0)->comment('合同金额');
            $table->decimal('down_payment', 11, 2)->default(0)->comment('首付款');
            $table->timestamp('expected_return_at')->default('0000-00-00 00:00:00')->comment('预计回款日期');
            $table->decimal('tail_amount', 11, 2)->default(0)->comment('尾款金额');
            $table->timestamp('tail_amount_at')->default('0000-00-00 00:00:00')->comment('尾款日期');
            $table->timestamp('product_delivery_at')->default('0000-00-00 00:00:00')->comment('产品交付日期');
            $table->bigInteger('created_user_id')->default(0)->comment('创建用户ID');
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
        Schema::drop('contract');
    }
}
