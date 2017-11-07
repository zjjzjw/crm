<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeveloperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->default(0)->commet('公司ID');
            $table->integer('province_id')->default(0)->comment('省份ID');
            $table->integer('city_id')->default(0)->comment('城市ID');
            $table->string('name', 50)->default('')->comment('分公司名称');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *`
     * @return void
     */
    public function down()
    {
        Schema::drop('developer');
    }
}
