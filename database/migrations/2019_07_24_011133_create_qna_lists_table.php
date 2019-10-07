<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQnaListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qna_lists', function (Blueprint $table) {
            $table->bigIncrements('id');                //QNA编号
            $table->text('name');                       //QNA名称
            $table->integer('faq_id');                   //FAQ id
            $table->boolean('isContextOnly');           //是否有上下文语境
            $table->text('PromptDTO');                  //是否有弹出互交框
            $table->text('MetadataDTO');                //标签
            $table->text('answer');                     //回答
            $table->text('questions');                  //问题列表
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
        Schema::dropIfExists('qna_lists');
    }
}
