<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'José Jaime Rodríguez Hernández',
            'username' => 'James',
            'company_id' => 1,
            'hotel_id' => 1,
            'is_admin' => true,
            'role_id' => 1,
            'comission_kids' => '5',
            'comission_adults' => '10',
            'comission_adults' => '5',
            'email' => 'james@gmail.com',
            'password' => bcrypt('%dlska@qRP'),
        ]);
        DB::table('users')->insert([
            'name' => 'Administrador',
            'username' => 'admin',
            'company_id' => 1,
            'hotel_id' => 1,
            'is_admin' => true,
            'role_id' => 1,
            'email' => 'admin@admin.com',
            'password' => bcrypt('%dlska@qRP'),
        ]);
        DB::table('users')->insert([
            'name' => 'Jessy Maxibus',
            'username' => 'jessy',
            'company_id' => 2,
            'hotel_id' => 2,
            'is_admin' => true,
            'role_id' => 1,
            'email' => 'jessy@example.com',
            'password' => bcrypt('jessy20202908'),
        ]);
    }
}
