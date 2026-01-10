<?php

use Illuminate\Database\Seeder;

class DepartureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('departures')->insert([
            'tour_id' => 1,
            'horario' => '10:00:00'
        ]);
        DB::table('departures')->insert([
            'tour_id' => 1,
            'horario' => '12:00:00'
        ]);
        DB::table('departures')->insert([
            'tour_id' => 2,
            'horario' => '17:30:00'
        ]);
        DB::table('departures')->insert([
            'tour_id' => 2,
            'horario' => '14:25:00'
        ]);
        DB::table('departures')->insert([
            'tour_id' => 3,
            'horario' => '23:00:00'
        ]);
        DB::table('departures')->insert([
            'tour_id' => 4,
            'horario' => '19:45:00'
        ]);
    }
}
