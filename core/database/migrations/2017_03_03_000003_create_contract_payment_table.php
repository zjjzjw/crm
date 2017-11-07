<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_payment', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('contract_id')->default(0)->comment('合同ID');
            $table->integer('period')->default(0)->comment('期数');
            $table->decimal('payment_amount', 11, 2)->default(0)->comment('回款金额');
            $table->integer('payment_type')->default(0)->comment('回款类型');
            $table->timestamp('payment_at')->default('0000-00-00 00:00:00')->comment('回款日期');
            $table->tinyInteger('status')->default(0)->commment('状态');
            $table->string('note', 255)->default('')->comment('备注');

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
        Schema::drop('contract_payment');
    }
}
