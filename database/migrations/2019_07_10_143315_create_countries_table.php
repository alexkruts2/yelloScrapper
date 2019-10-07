<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            /*----- 基本信息 -----*/
            $table->string('name_cn');          //中文名称
            $table->string('name_en');          //英文名称
            $table->string('calling_code',6);   //电话代码
            $table->string('language');         //语言
            $table->string('currency',6);       //货币
            $table->string('symbol', 5);        //货币符号
            $table->string('flag', 512)->nullable();    //国旗
            /*----- 即时房价信息 -----*/
            $table->double('inflation_cpi')->nullable();    //通货膨胀
            $table->double('hpi')->nullable();          //房价指数
            $table->double('hpi_yoy')->nullable();      //房价年变化
            $table->double('hh_debt_gdp')->nullable();      //家庭负债率
            /*----- 利率汇率 -----*/
            $table->boolean('is_loanable')->default(true);    //可贷款
            $table->double('interest_rate')->nullable();    //央行利率
            $table->double('mortgage_rate')->nullable();    //私人贷款利率
            $table->double('rmb_exchange')->nullable();     //人民币计价汇率
            /*----- 其他信息 -----*/
            $table->double('consumer_confi')->nullable();   //消费者信心
            $table->double('unemployment')->nullable();     //失业率
            $table->double('gdp_growth')->nullable();       //GDP增长率
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
        Schema::dropIfExists('countries');
    }
}
