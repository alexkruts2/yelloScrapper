<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirbnbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airbnbs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('room_id');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('photos')->nullable();
            $table->string('listing_type')->nullable();
            $table->string('property_type')->nullable();
            $table->boolean('is_entire')->nullable();
            $table->integer('max_guest')->nullable();
            $table->integer('bed_room')->nullable();
            $table->integer('bed')->nullable();
            $table->integer('bath_room')->nullable();
            $table->string('bath_room_type')->nullable();
            $table->text('amenties')->nullable();
            $table->string('suburb')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->text('cancellation')->nullable();
            $table->string('price_per_night')->nullable();
            $table->string('currency')->nullable();
            $table->text('reviews')->nullable();
            $table->integer('review_counts')->nullable();
            $table->text('host')->nullable();
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
        Schema::dropIfExists('airbnbs');
    }
}
