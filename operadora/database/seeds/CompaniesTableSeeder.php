<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('companies')->insert([
            'name' => 'Operadora',
            'description' => 'Operadora Zacatecas',
            'address' => 'Zacatecas, centro',
            'owner' => 'Fulanito detal'
        ]);
        DB::table('companies')->insert([
            'name' => 'Maxibus',
            'description' => 'Maxibus Zacatecas',
            'address' => 'Zacatecas, centro',
            'owner' => 'Fulanita detal'
        ]);
    }
}
