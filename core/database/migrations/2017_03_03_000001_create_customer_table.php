<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->bigInteger('company_id')->default(0)->comment('公司ID');
            $table->string('customer_company_name')->default('')->comment('所在公司');
            $table->integer('province_id')->default(0)->comment('省份ID');
            $table->integer('city_id')->default(0)->comment('城市ID');
            $table->string('contact_name', 50)->default('')->comment('联系人名称');
            $table->string('position_name', 50)->default('')->comment('联系人岗位');
            $table->string('contact_phone', 50)->default('')->comment('联系人电话');
            $table->integer('project_count')->default(0)->comment('项目数量');
            $table->integer('build_project_count')->default(0)->comment('建设项目数量');
            $table->integer('future_potential')->default(0)->comment('未来潜量');
            $table->string('record')->default('')->comment('开发记录');
            $table->string('use_brand')->default('')->comment('使用品牌');
            $table->integer('volume')->default(0)->comment('体量');
            $table->tinyInteger('level')->default(0)->comment('客户等级');
            $table->timestamp('per_signed_at')->default('0000-00-00 00:00:00')->comment('预计签约时间');
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
        Schema::drop('customer');
    }
}
