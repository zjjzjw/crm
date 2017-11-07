<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('company_id')->default(0)->comment('公司ID');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->string('name', 50)->default('')->comment('姓名');
            $table->string('initials', 10)->default('')->comment('首字母');
            $table->string('full_pinyin', 255)->default('')->comment('全拼');
            $table->string('phone', 20)->default('')->comment('手机');
            $table->string('tel', 20)->default('')->comment('电话');
            $table->string('email', 50)->default('')->comment('邮件');
            $table->string('position_name', 50)->default('')->comment('职位');
            $table->string('company_name', 50)->default('')->comment('公司');
            $table->string('address')->default('')->comment('地址');
            $table->string('zip_code', 20)->default('')->comment('邮编');

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
        Schema::drop('card');
    }
}
