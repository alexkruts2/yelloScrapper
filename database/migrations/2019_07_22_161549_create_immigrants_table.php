<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImmigrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immigrants', function (Blueprint $table) {
            /*----- 基本信息 ------*/
            $table->bigIncrements('id');        //编号
            $table->text('hash');                    //hash
            $table->text('name_cn');                 //项目中文名
            $table->text('name_en');                 //项目英文名
            $table->integer('country_id');           //国家
            $table->integer('state_id');             //州/省/区域
            $table->text('main_description')->nullable();        //前端主描述
            $table->text('secondary_description')->nullable();   //前端短描述
            $table->text('tags');                    //标签
            $table->text('immi_link')->nullable();                  //官方移民局信息链接
            $table->integer('duration');             //下签/办理周期
            $table->enum('type', config('enum.immi_type'))->default('投资移民');  //类型   :   投资移民; 独立技术移民; 雇主担保移民; 买房移民; 退休移民; 护照项目。
            /*----- P3 信息 ------*/
            $table->text('language_req')->nullable();        //语言要求
            $table->text('language_level')->nullable();      //语言要求等级
            $table->text('language_des')->nullable();        //语言要求描述
            $table->boolean('is_invest_req')->nullable();       //是否需要投资
            $table->integer('invest_amount')->nullable();       //投资金额
            $table->boolean('is_capital_proof')->nullable();    //是否需要资金来源证明
            $table->integer('invest_des')->nullable();          //投资要求描述
            $table->boolean('is_employment_req')->nullable();   //是否需要雇人
            $table->integer('employment_amount')->nullable();   //雇员人数
            $table->text('employment_des')->nullable();      //雇佣要求描述
            $table->boolean('is_asset_req')->nullable();        //是否在当地需要拥有资产
            $table->integer('asset_amount')->nullable();        //资产金额
            $table->text('property_employment_des')->nullable();      //资产要求描述
            $table->boolean('is_onshore')->nullable();          //是否需要在当地居住
            $table->text('onshore_period')->nullable();      //居住周期
            $table->text('onshore_des')->nullable();         //居住要求描述
            $table->text('document')->nullable();               //材料
            $table->text('official_link')->nullable();          //政府官方介绍
            /*----- P2 信息 ------*/
            $table->text('faq_ids')->nullable();                 //FAQ
            $table->text('adv')->nullable();                    //项目优势
            $table->text('requirements')->nullable();           //申请条件
            $table->text('process')->nullable();                //步骤名称
            $table->text('fee')->nullable();                    //费用
            $table->text('images')->nullable();                 //图片
            $table->text('video')->nullable();                  //视频

            $table->string('trainer')->nullable();              //培训人
            $table->string('training_video')->nullable();       //培训视频
            $table->text('training_articles')->nullable();      //培训文章
            $table->integer('internal_manager_id')->nullable(); //项目负责人

            $table->boolean('is_published')->default(false);    //是否发布
            $table->dateTime('published_at')->nullable();       //发布时间
            $table->boolean('is_hot')->default(false);    //是否热门
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
        Schema::dropIfExists('immigrants');
    }
}
