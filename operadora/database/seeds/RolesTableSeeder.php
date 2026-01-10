<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            'type' => 'Operador',
            'administrator' => false,
        ]);
        DB::table('roles')->insert([
            'type' => 'Recepción',
            'administrator' => false,
        ]);
        DB::table('roles')->insert([
            'type' => 'Módulo',
            'administrator' => false,
        ]);

    }
}
