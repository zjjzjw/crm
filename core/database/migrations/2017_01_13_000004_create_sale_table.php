<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->bigInteger('company_id')->default(0)->comment('公司ID');
            $table->string('project_name', '50')->default('')->comment('项目名称');
            $table->integer('province_id')->default(0)->comment('省份ID');
            $table->integer('city_id')->default(0)->comment('城市ID');
            $table->string('address')->default('')->comment('详细地址');
            $table->string('developer_name')->default('')->comment('所属开发商');
            $table->string('developer_group_name')->default('')->comment('所属开发商集团名称');
            $table->integer('project_volume')->default(0)->comment('项目体量');
            $table->integer('project_step_id')->default(0)->comment('项目所处阶段');
            $table->string('contact_name')->default('')->comment('联系人');
            $table->string('position_name')->default('')->comment('职位');
            $table->string('contact_phone')->default('')->comment('联系人电话');
            $table->bigInteger('created_user_id')->default(0)->comment('记录创建者ID');
            $table->tinyInteger('status')->default(0)->comment('销售线索状态');
            $table->tinyInteger('close_status')->default(0)->comment('销售线索关闭状态');

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
        Schema::drop('sale');
    }
}
