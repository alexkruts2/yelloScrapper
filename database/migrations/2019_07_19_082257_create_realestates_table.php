<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealestatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realestates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("url");
            $table->integer("property_id");
            $table->text("photos");
            $table->string("address_street");
            $table->string("suburb");
            $table->string("state");
            $table->string("post_code");
            $table->integer("bed");
            $table->integer("bath");
            $table->integer("car_space");
            $table->string("property_type");
            $table->string("price");
            $table->string("available_date");
            $table->string("title");
            $table->text("description");
            $table->string("lat");
            $table->string("lon");
            $table->string("agent_brand");
            $table->string("agent_name");
            $table->string("agent_phone");
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
        Schema::dropIfExists('realestates');
    }
}
