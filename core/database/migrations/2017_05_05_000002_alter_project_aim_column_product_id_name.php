<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProjectAimColumnProductIdName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_aim', function ($table) {
            $table->renameColumn('product_id', 'product_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_aim', function ($table) {
            $table->renameColumn('product_ids', 'product_id');
        });
    }
}
