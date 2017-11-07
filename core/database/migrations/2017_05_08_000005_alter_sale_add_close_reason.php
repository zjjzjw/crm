<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSaleAddCloseReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale', function ($table) {
            $table->string('close_reason')->default('')->comment('关闭原因')->after('close_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale', function ($table) {
            $table->dropColumn('close_reason');
        });
    }

}
