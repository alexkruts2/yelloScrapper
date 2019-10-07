<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("url");
            $table->string("article_title");
            $table->string("article_author")->nullable();
            $table->string("weixin_name");
            $table->string("weixin_nickname")->nullable();
            $table->string("article_publish_time")->nullable();
            $table->string("article_thumbnail")->nullable();
            $table->text("article_brief")->nullable();
            $table->text("article_content")->nullable();
            $table->string("is_original",5)->nullable();
            $table->string("weixin_avatar")->nullable();
            $table->string("weixin_introduce")->nullable();
            $table->string("weixin_qr_code")->nullable();
            $table->text("article_images")->nullable();
            $table->string("weixin_tmp_url")->nullable();
            $table->string("biz")->nullable();
            $table->integer('idx')->nullable();
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
        Schema::dropIfExists('wechat_articles');
    }
}
