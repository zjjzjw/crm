<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropProjectFileColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_file', function(Blueprint $table)
        {
            $table->dropColumn('file_model');
            $table->dropColumn('price');
            $table->dropColumn('evaluate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_file', function(Blueprint $table)
        {
            $table->string('file_model', 255)->default('')->comment('型号')->after('bench_brands');
            $table->decimal('price', 10, 2)->default(0)->comment('价格')->after('bench_brands');
            $table->string('evaluate', 255)->default('')->comment('评价')->after('bench_brands');
        });
    }
}
