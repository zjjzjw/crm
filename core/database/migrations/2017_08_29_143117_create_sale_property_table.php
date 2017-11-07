<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_property', function (Blueprint $table) {
            $table->bigIncrements('id');
            //基本信息
            $table->bigInteger('sale_id')->default(0)->comment('销售id');
            $table->integer('developer_id')->default(0)->comment('开发商分公司id');
            $table->integer('developer_group_id')->default(0)->comment('开发商集团id');
            $table->timestamp('record_time')->default('0000-00-00 00:00:00')->comment('备案时间');
            $table->string('loupan_name', 50)->default('')->comment('楼盘名称');
            $table->integer('project_region_id')->default(0)->comment('工程大区划分id');
            $table->tinyInteger('sale_status')->default(0)->comment('销售状态 1=在售 2=待售 3=售完');

            //建筑信息
            $table->string('building_developer_name', 255)->default('')->comment('建筑开发商');
            $table->tinyInteger('decoration_type')->default(0)->comment('装修类别 1=毛坯 2=精装 3=部分精装 4=菜单式/选装 5=未确定');
            $table->integer('house_total')->default(0)->comment('总户数');
            $table->decimal('hardcover_standard', 11, 2)->default(0)->comment('精装标准(元/m2)');
            $table->integer('at_hardcover_house_total')->default(0)->comment('当前精装户数');
            $table->string('floor_condition', 255)->default('')->comment('楼层情况');
            $table->integer('floor_total')->default(0)->comment('楼栋总数');
            $table->integer('area_covered')->default(0)->comment('占地面积');
            $table->integer('architecture_covered')->default(0)->comment('建筑面积');
            $table->tinyInteger('project_schedule')->default(0)->comment('工程进度 1=在建中 2=规划中 3=已封顶 4=已竣工 5=已交房 6=未确定');

            //物业信息
            $table->integer('property_type')->default(0)->comment('物业类型 1=普通住宅 2=公寓 3=别墅 4=洋房 5=写字楼 6=商铺 7=商住两用 8=其他');
            $table->string('property_company', 50)->default('')->comment('物业公司');

            $table->decimal('housing_price', 11, 2)->default(0)->comment('楼盘均价(元/m2)');
            $table->tinyInteger('has_sample_house')->default(0)->comment('是否有样板房 1=是 2=否');
            $table->integer('brand_id')->default(0)->comment('样板房配套品牌id');
            $table->timestamp('opening_time')->default('0000-00-00 00:00:00')->comment('开盘时间');
            $table->timestamp('handing_time')->default('0000-00-00 00:00:00')->comment('交房时间');
            $table->string('sale_phone', 50)->default('')->comment('售楼电话');
            $table->integer('strategy_id')->default(0)->comment('战略归属 1=方太战略 2=竞品战略 3=无战略');
            $table->string('strategy_brand_other', 50)->default('')->comment('其他战略品牌');
            $table->integer('kitchen_budget')->default(0)->comment('厨电预算(元/套)');
            $table->integer('kitchen_configuration')->default(0)->comment('厨电配置(件数)');
            $table->string('contend_brand', 50)->default('')->comment('竞争品牌');
            $table->integer('project_position')->default(0)->comment('项目定位 1=必得项目 2=争取项目 3=竞品战略项目 4=装修标准过高 5=装修标准过低');
            $table->integer('project_status')->default(0)->comment('项目状态');
            $table->timestamp('project_estimate_signed_time')->default('0000-00-00 00:00:00')->comment('预估项目合同签约时间');
            $table->decimal('project_estimate_price', 11, 2)->default(0)->comment('项目签约金额(万元)');
            $table->tinyInteger('project_estimate_status')->default(0)->comment('项目签约情况 1=已签 2=未签');
            $table->text('project_loss_reason')->default('')->comment('项目丢失情况说明（原因）');

            //其他信息
            $table->text('remake')->default('')->comment('备注');
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
        Schema::drop('sale_property');
    }
}
