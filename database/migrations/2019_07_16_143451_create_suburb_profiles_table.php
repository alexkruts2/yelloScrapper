<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuburbProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suburb_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            /*----- 基本查询信息 -----*/
            $table->string('hash');                             //HASH ID
            $table->integer('suburb_id');                       //小区id
            $table->text('suburb_img')->nullable();             //小区图片

            /*----- 中位价与回报率 -----*/
            $table->string('apt_median_price');                 //公寓中位价
            $table->string('apt_median_rent');                  //公寓平均租金
            $table->string('apt_median_yield')->nullable();     //公寓平均回报率
            $table->string('house_median_price');               //别墅中位价
            $table->string('house_median_rent');                //别墅平均租金
            $table->string('house_median_yield')->nullable();   //别墅平均回报率

            /*----- 公寓房型分析 -----*/
            $table->string('apt_1bed_price')->nullable();       //公寓1房房价
            $table->string('apt_1bed_rent')->nullable();        //公寓1房租金
            $table->string('apt_2bed_price')->nullable();       //公寓2房房价
            $table->string('apt_2bed_rent')->nullable();        //公寓2房租金
            $table->string('apt_3bed_price')->nullable();       //公寓3房房价
            $table->string('apt_3bed_rent')->nullable();        //公寓3房租金

            /*----- 别墅房型分析 -----*/
            $table->string('house_2bed_price')->nullable();     //别墅2房房价
            $table->string('house_2bed_rent')->nullable();      //别墅2房租金
            $table->string('house_3bed_price')->nullable();     //别墅3房房价
            $table->string('house_3bed_rent')->nullable();      //别墅3房租金
            $table->string('house_4bed_price')->nullable();     //别墅4房房价
            $table->string('house_4bed_rent')->nullable();      //别墅4房租金

            /*----- 曲线 -----*/
            $table->text('apt_trend-monthly');                  //公寓月度趋势
            $table->text('house_trend-monthly');                //别墅月度趋势
            $table->text('apt_trend-yearly');                   //公寓年度趋势
            $table->text('house_trend-yearly');                 //别墅年度趋势

            /*----- 当前市场情况 -----*/
            $table->integer('on_sale');                         //正在出售数量
            $table->integer('on_rental');                       //正在出租数量

            /*----- 人口结构 -----*/
            $table->string('Young_Families');                   //35岁以下年轻家庭
            $table->string('Independent_Youth');                //35岁以下独立青年
            $table->string('Maturing_Couples_Families');        //35-44岁成熟家庭
            $table->string('Maturing_Independence');            //35-54岁成熟独居个人
            $table->string('Established_Couples_Families');     //45-54岁年长家庭
            $table->string('Older_Couples_Families');           //55-64岁长辈家庭
            $table->string('Older_Independence');               //55-64岁独居年长个人
            $table->string('Elderly_Families');                 //65岁以上家庭
            $table->string('Elderly_Singles');                  //65岁以上独居年长个人


            /*----- 人口结构 -----*/
            $table->boolean('is_commented')->nullable();        //是否有评价
            $table->text('comment')->nullable();                //评价

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
        Schema::dropIfExists('suburb_profiles');
    }
}
