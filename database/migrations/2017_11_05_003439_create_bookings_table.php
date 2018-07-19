<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBookingsTable
 *
 * @author Pisyek K
 * @url www.pisyek.com
 * @copyright © 2017 Pisyek Studios
 */
class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('booked_by');
            $table->unsignedInteger('room_id');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->tinyInteger('status')->default(\App\Enumerations\BookingStatus::OPTION);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('room_id')
                  ->references('id')->on('rooms')
                  ->onDelete('cascade');
        });

        Schema::table('bookings', function(Blueprint $table) {
            $table->foreign('booked_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
