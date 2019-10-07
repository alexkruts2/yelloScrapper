<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            /*----- 基本信息 -----*/
            $table->string('hash');                             //HASH ID
            $table->string('name_cn')->nullable();              //项目中文名
            $table->string('name_en');                          //项目英文名
            $table->string('developer_name_cn')->nullable();    //开发商中文名
            $table->string('developer_name_en')->nullable();    //开发商英文名
            $table->integer('country_id');                      //国家
            $table->integer('state_id')->nullable();            //州
            $table->integer('city_id')->nullable();             //城市
            $table->integer('suburb_id')->nullable();           //小区

            /*----- P2 权限信息 -----*/
            $table->text('images')->nullable();                 //图片
            $table->string('video')->nullable();            //视频
            $table->string('audio')->nullable();            //语音
            $table->double('price_max')->nullable();            //价格上限
            $table->double('price_min')->nullable();            //价格下限
            $table->double('initial_deposit')->nullable();      //首付比例
            $table->boolean('mortgage')->default(true);             //贷款
            $table->double('ltv_ratio')->nullable();            //贷款比例
            $table->double('rental_yield')->nullable();        //租金
            $table->integer('prop_type')->nullable();                       //物业类型
            $table->string('prop_title')->nullable();           //产权类型
            $table->string('volume')->nullable();               //体量
            $table->enum('status', config('enum.property_status'))->default('期房');      //状态
            $table->string('settle_date')->nullable();          //预期交房
            $table->string('construct_date')->nullable();       //预期开工
            $table->text('tags')->nullable();                   //标签
            $table->text('description')->nullable();            //描述
            $table->text('developer_comment')->nullable();      //开发商描述

            /*----- 附加服务 -----*/
            $table->string('faq_ids')->nullable();              //FAQ
            $table->integer('location_id')->nullable();         //地段分析
            $table->integer('profile_id')->nullable();          //小区分析

            /*----- P3 权限信息 -----*/
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('address')->nullable();
            $table->enum('commission_type', config('enum.commission_type'))->default('百分比');    //佣金类型
            $table->double('commission')->nullable();           //佣金
            $table->double('commission_land')->nullable();           //土地佣金
            $table->double('commission_construct')->nullable();           //土地佣金
            $table->string('commission_comment')->nullable();   //佣金备注
            $table->double('unit_price_override')->nullable();  //单价
            $table->text('packages')->nullable();               //文件打包(type, url, comment)
            $table->text('files')->nullable();                  //小文件(file_id, name, type, link, date)
            $table->string('trainer')->nullable();              //培训人
            $table->string('training_video')->nullable();      //培训视频
            $table->text('training_articles')->nullable();      //培训文章
            $table->integer('internal_manager_id')->nullable(); //项目负责人
            $table->boolean('is_published')->default(false);    //是否发布
            $table->dateTime('published_at')->nullable();       //发布时间
            $table->boolean('is_hot')->default(false);    //是否热销
            $table->boolean('is_recommended')->default(false);    //是否推荐
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
        Schema::dropIfExists('properties');
    }
}
