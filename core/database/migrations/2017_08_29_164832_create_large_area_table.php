<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLargeAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('large_area', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('company_id')->default(0)->comment('公司ID');
            $table->string('name', 50)->default('')->comment('大区名称');
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
        Schema::drop('large_area');
    }
}
