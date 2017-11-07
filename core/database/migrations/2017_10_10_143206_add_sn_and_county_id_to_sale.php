<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSnAndCountyIdToSale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale', function(Blueprint $table)
        {
            $table->string('sn', 20)->default('')->comment('编号')->after('id');
            $table->integer('county_id')->default(0)->comment('县id')->after('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale', function(Blueprint $table)
        {
            $table->dropColumn('sn');
            $table->dropColumn('county_id');
        });
    }
}
