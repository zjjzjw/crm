<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->default(0)->comment('公司ID');
            $table->string('name')->default('')->comment('姓名');
            $table->string('email')->default('')->comment('邮箱');
            $table->char('phone', 11)->default('')->comment('手机号');
            $table->string('password')->default('')->comment('密码');
            $table->timestamp('start_time')->default('0000-00-00 00:00:00')->comment('生效时间');
            $table->timestamp('end_time')->default('0000-00-00 00:00:00')->comment('失效效时间');
            $table->bigInteger('created_user_id')->default(0)->comment('创建者用户ID');
            $table->integer('image_id')->default(0)->comment('用户头像ID');
            $table->rememberToken();
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
        Schema::drop('user');
    }
}
