<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ToursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tours')->insert([
            'name' => 'Zacatecas impresionante',
            'company_id' => 1,
            'cost_kids' => 80,
            'cost_adults' => 100,
            'cost_elders' => 70,
            'limit' => 55,
            'active' => true,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'current' => Carbon::now()->toDateString(),
        ]);
        DB::table('tours')->insert([
            'name' => 'Total Pass',
            'company_id' => 1,
            'cost_kids' => 399,
            'cost_adults' => 499,
            'cost_elders' => 399,
            'limit' => 400,
            'active' => true,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'current' => Carbon::now()->toDateString(),
        ]);
        DB::table('tours')->insert([
            'name' => 'Leyendas con el Diablo de Zacatecas',
            'company_id' => 2,
            'cost_kids' => 60,
            'cost_adults' => 70,
            'cost_elders' => 70,
            'limit' => 40,
            'active' => true,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'current' => Carbon::now()->toDateString(),
        ]);
        DB::table('tours')->insert([
            'name' => 'Tour centro historico',
            'company_id' => 2,
            'cost_kids' => 60,
            'cost_adults' => 70,
            'cost_elders' => 70,
            'limit' => 40,
            'active' => true,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'current' => Carbon::now()->toDateString(),
        ]);
        DB::table('tours')->insert([
            'name' => 'Tour Revolucionario',
            'company_id' => 2,
            'cost_kids' => 60,
            'cost_adults' => 70,
            'cost_elders' => 70,
            'limit' => 40,
            'active' => true,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'current' => Carbon::now()->toDateString(),
        ]);
    }
}
