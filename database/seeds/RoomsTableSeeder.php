<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            \App\Room::create([
                'name' => 'Standard Room ' . $i,
                'pax' => rand(1,4)
            ]);

            \App\Room::create([
                'name' => 'Deluxe Room ' . $i,
                'pax' => rand(1,4)
            ]);
        }

    }
}
