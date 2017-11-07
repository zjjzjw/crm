<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeveloperGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_group', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('company_id')->default(0)->comment('公司ID');
            $table->string('name', 50)->default('')->comment('集团名称');
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
        Schema::drop('developer_group');
    }
}
