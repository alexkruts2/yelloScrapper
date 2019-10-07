<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            /*----- 基本信息 -----*/
            $table->string('hash');         //户型 Hash
            $table->integer('property_price_list_id');      //归属价格单的id
            $table->string('unit_number');      //户型号

            /*----- 销售权限配置 -----*/
            $table->enum('status', config('enum.unit_status'))->default('1');   //销售状态
            $table->integer('sales_group')->nullable();     //分销团队

            /*----- 其他信息 -----*/
            $table->boolean('is_recommended')->default(false);      //是否推荐
            $table->string('cal_hash')->nullable();         //投资 HASH
            $table->enum('aspect', config('enum.aspect'))->nullable();  //朝向
            $table->enum('contract_type', config('enum.contract_type'))->default('1');  //合同类型

            /*----- 户型信息 -----*/
            $table->integer('room');        //房间数
            $table->integer('bath');        //卫生间
            $table->integer('garage')->nullable();      //车位
            $table->integer('study')->nullable();       //书房
            $table->integer('living')->nullable();      //客厅

            /*----- 面积信息 -----*/
            $table->string('size_unit');        //面积单位
            $table->double('internal_size')->nullable();        //套内面积
            $table->double('external_size')->nullable();        //阳台面积
            $table->integer('level')->nullable();       //楼层
            $table->double('land_size')->nullable();        //土地面积
            $table->double('structure_size')->nullable();   //建筑面积
            $table->integer('house_type')->nullable();      //别墅楼层

            /*----- 户型图 -----*/
            $table->string('floorplan')->nullable();        //户型图
            $table->string('additional_file')->nullable();  //补充材料

            /*----- 价格信息 -----*/
            $table->double('total_price');          //价格
            $table->double('structure_price')->nullable();      //建筑价格
            $table->double('land_price')->nullable();       //土地价格
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_units');
    }
}
