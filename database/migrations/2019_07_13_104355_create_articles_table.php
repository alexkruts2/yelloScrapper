<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            /*----- 基本信息 -----*/
            $table->string('hash');
            $table->string('name');     //文章标题
            $table->text('lite_des');       //短描述
            $table->mediumText('full_des')->nullable();       //长描述
            $table->boolean('is_whitelabelled')->default(true);     //品牌信息声明
            /*----- 标签/分类 -----*/
            $table->string('tags')->nullable();     //标签
            $table->integer('category_id')->nullable();    //分类
            $table->boolean('is_top')->default(false);      //是否置顶
            /*----- 文章涉及的地区 -----*/
            $table->integer('country_id')->nullable();     //国家
            $table->integer('state_id')->nullable();       //州/省/地区
            $table->integer('city_id')->nullable();        //城市
            /*----- 版权 -----*/
            $table->string('author');       //作者
            $table->string('source_url', 1024)->nullable();     //来源地址
            $table->enum('copyright_type', config('enum.copyright_type'))->default(5);      //版权状态 1=网络采集，2=微信采集，3=原创，4=授权发布，5=未知。要根据这些状态，来展示不同的版权声明。
            /*----- 编辑信息 -----*/
            $table->integer('editor')->nullable();      //编辑人 如果文章发布了，则这里记录发布人的hash id
            $table->boolean('is_published')->default(false);    //是否发布
            $table->dateTime('published_at')->nullable();       //发布时间
            $table->dateTime('content_updated_at')->nullable();
            /*----- 文章内容 -----*/
            $table->mediumText('content')->nullable();      //文章内容
            $table->mediumText('texted_content')->nullable();   //文章内容纯文字
            $table->string('head_pic', 512)->nullable();        //首页大图
            $table->string('thumb_pic', 512)->nullable();   //缩略图
            $table->text('images')->nullable();
            $table->string('qr_code')->nullable();
            /*----- 统计信息 -----*/
            $table->integer('view_counts')->default(0);     //查看次数
            $table->integer('share_counts')->default(0);    //分享次数
            $table->text('shared')->nullable();         //分享人hash id的组合。展示在前端在文章查看/编辑页面，点击他们的头像，可以打开对应的文章分享链接。
            /*----- 公众号信息 -----*/
            $table->string('official_name')->nullable();        //公众号名称
            $table->string('official_avatar')->nullable();      //公众号头像
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
        Schema::dropIfExists('articles');
    }
}
