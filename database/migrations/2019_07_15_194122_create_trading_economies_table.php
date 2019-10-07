<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradingEconomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trading_economies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('country_id');
            $table->string('country_name');
            $table->double('inflation_cpi')->nullable();
            $table->double('hpi')->nullable();
            $table->double('hpi_yoy')->nullable();
            $table->double('hh_debt_gdp')->nullable();
            $table->double('interest_rate')->nullable();
            $table->double('mortgage_rate')->nullable();
            $table->double('consumer_confi')->nullable();
            $table->double('unemployment')->nullable();
            $table->double('gdp_growth')->nullable();
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
        Schema::dropIfExists('trading_economies');
    }
}
