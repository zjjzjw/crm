<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->default('')->comment('公司名称');
            $table->timestamp('start_time')->default('0000-00-00 00:00:00')->comment('有效期开始时间');
            $table->timestamp('end_time')->default('0000-00-00 00:00:00')->comment('有效期结束时间');
            $table->integer('user_number')->default(0)->comment('账户人数');
            $table->smallInteger('is_free')->default(0)->comment('是否免费');
            $table->bigInteger('created_user_id')->default(0)->comment('创建者用户ID');
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
        Schema::drop('company');
    }
}
