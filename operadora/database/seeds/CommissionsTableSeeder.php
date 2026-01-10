<?php

use Illuminate\Database\Seeder;

class CommissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('commissions')->insert([
            'user_id' => 1,
            'tour_id' => 1,
            'kids' => 4,
            'adults' => 5,
            'elders' => 5,
        ]);
        DB::table('commissions')->insert([
            'user_id' => 1,
            'tour_id' => 2,
            'kids' => 3,
            'adults' => 3,
            'elders' => 3,
        ]);
    }
}
