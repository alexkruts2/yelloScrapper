<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hash');                     //Hash ID
            /*----- 需要用户自主填写的信息部分 -----*/
            $table->string('name');                     //名称
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();       //头像
            $table->string('country_code', 10)->nullable(); //国家代码
            $table->string('mobile', 20)->unique()->nullable();       //手机
            $table->string('state', 32)->nullable();        //地区/省/州
            $table->string('city', 32)->nullable();         //城市
            $table->string('company', 128)->nullable();      //公司
            $table->string('title', 128)->nullable();       //职位
            $table->string('profession', 32)->nullable();   //业务领域
            $table->string('experience', 10)->nullable();   //经验
            $table->string('personal_des')->nullable();         //自我描述
            /*----- 经授权后可直接获得的用户信息 -----*/
            $table->string('wechat_name')->nullable();          //微信名称
            $table->string('wechat_avatar')->nullable();        //微信头像
            $table->string('country')->nullable();              //国家
            $table->string('wechat_state')->nullable();         //地区/省/州
            $table->string('wechat_city')->nullable();          //城市
            $table->string('gender', 2)->nullable();     //性别
            $table->string('wechat_qr')->nullable();            //微信二维码
            /*----- 用户权限属性部分 -----*/
            $table->boolean('is_admin')->default(false);    //是否为管理员
            $table->string('union_id')->nullable();             //开放平台
            $table->string('hcmini_open_id')->nullable();      //海潮小程序的OPEN_ID
            $table->enum('user_type', config('enum.user_type'))->default('agent');
            $table->string('password')->nullable();                 //密码
            $table->dateTime('last_login_dt')->nullable();      //最后后台登录时间
            $table->integer('login_counts')->default(0);    //登录次数
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
