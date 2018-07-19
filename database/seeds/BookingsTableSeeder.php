<?php

use Illuminate\Database\Seeder;
use App\Enumerations\BookingStatus;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $start = \Carbon\Carbon::now();
            $interval = (int) rand(2,5);
            $end = \Carbon\Carbon::now()->addDays($interval);

            $data = [
                'room_id' => $i+1,
                'booked_by' => 1,
                'start_date' => $start,
                'end_date' => $end,
                'status' => BookingStatus::ACTIVE
            ];

            \App\Booking::create($data);
        }
    }
}
