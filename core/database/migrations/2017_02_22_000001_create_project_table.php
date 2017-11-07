<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->bigInteger('company_id')->default(0)->comment('公司ID');
            $table->string('project_name')->default('')->comment('项目名称');
            $table->integer('province_id')->default(0)->comment('省份ID');
            $table->integer('city_id')->default(0)->comment('城市ID');
            $table->string('address', 255)->default('')->comment('详细地址');
            $table->string('developer_name', 255)->default('')->comment('开发商名称');
            $table->string('contact_name', 50)->default('')->comment('联系人名称');
            $table->string('contact_phone', 50)->default('')->comment('联系人电话');
            $table->integer('project_volume')->default(0)->comment('体量');
            $table->string('use_brands')->default('')->comment('使用品牌');
            $table->timestamp('signed_at')->default('0000-00-00 00:00:00')->comment('合同签订时间');
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
        Schema::drop('project');
    }
}
