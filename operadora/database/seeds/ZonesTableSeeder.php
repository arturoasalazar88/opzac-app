<?php

use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('zones')->insert([
            'name' => 'Zona Sur',
            'number' => 1,
            'closure' => '15'
        ]);
        DB::table('zones')->insert([
            'name' => 'Zona Norte',
            'number' => 2,
        ]);
        DB::table('zones')->insert([
            'name' => 'Zona Este',
            'number' => 3,
        ]);
        DB::table('zones')->insert([
            'name' => 'Zona Oeste',
            'number' => 4,
        ]);
        /***************************/
        /* We must need a diferent
        /* approach
        /***************************/
        // DB::table('zones')->insert([
        //     'name' => 'Zona Sur 2',
        //     'number' => 1,
        //     'closure' => '10:00',
        //     'company_id' => 2,
        // ]);
        // DB::table('zones')->insert([
        //     'name' => 'Zona Norte 2',
        //     'number' => 2,
        //     'closure' => '12:00',
        //     'company_id' => 2,
        // ]);
        // DB::table('zones')->insert([
        //     'name' => 'Zona Este 2',
        //     'number' => 3,
        //     'closure' => '14:00',
        //     'company_id' => 2,
        // ]);
        // DB::table('zones')->insert([
        //     'name' => 'Zona Oeste 2',
        //     'number' => 4,
        //     'closure' => '12:30',
        //     'company_id' => 2,
        // ]);
    }
}
