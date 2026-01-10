<?php

use Illuminate\Database\Seeder;

class HotelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('hotels')->insert([
            'name' => 'Operadora',
            'key' => 'OP',
            'zone_id' => 1,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Maxibus',
            'key' => 'MX',
            'zone_id' => 1,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Casa Real',
            'key' => 'CR',
            'zone_id' => 2,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Plaza',
            'key' => 'PL',
            'zone_id' => 2,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Don Miguel',
            'key' => 'DM',
            'zone_id' => 2,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Zacatecas Courts',
            'key' => 'ZC',
            'zone_id' => 2,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Colon',
            'key' => 'CL',
            'zone_id' => 2,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Arroyo de la PLata',
            'key' => 'AP',
            'zone_id' => 2,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Campanario',
            'key' => 'CP',
            'zone_id' => 2,
        ]);
        DB::table('hotels')->insert([
            'name' => 'María Benita',
            'key' => 'MB',
            'zone_id' => 2,
        ]);
        DB::table('hotels')->insert([
            'name' => 'María Conchita',
            'key' => 'MC',
            'zone_id' => 2,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Reyna Soledad',
            'key' => 'RS',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Casa Torres',
            'key' => 'CT',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Casa Cortés',
            'key' => 'CC',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Argento Inn',
            'key' => 'AI',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Posada de la Moneda',
            'key' => 'PM',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Santa Rita',
            'key' => 'SR',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Emporio',
            'key' => 'EP',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Santa Lucía',
            'key' => 'SL',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Santo Domingo',
            'key' => 'SM',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Hostal del Carmen',
            'key' => 'HC',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Hostal Ángeles',
            'key' => 'HA',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Posada Tolosa',
            'key' => 'PT',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Finca del Minero',
            'key' => 'FM',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Terrase',
            'key' => 'TR',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Hostal del Vasco',
            'key' => 'HV',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Casa Arechiga',
            'key' => 'CA',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Casona de los Vitrales',
            'key' => 'CV',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Mesón de Jobito',
            'key' => 'MJ',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Mesón de la Merced',
            'key' => 'MM',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Condesa',
            'key' => 'CO',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Refugio de Don Carlos',
            'key' => 'RDC',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Quinta Real',
            'key' => 'QR',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Alica',
            'key' => 'AL',
            'zone_id' => 3,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Baruk Teleférico',
            'key' => 'BT',
            'zone_id' => 1,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Parador',
            'key' => 'PR',
            'zone_id' => 1,
        ]);
        DB::table('hotels')->insert([
            'name' => 'City Express',
            'key' => 'CE',
            'zone_id' => 1,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Hampton Inn',
            'key' => 'HI',
            'zone_id' => 1,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Fiesta Inn',
            'key' => 'FI',
            'zone_id' => 1,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Hacienda Baruk',
            'key' => 'HB',
            'zone_id' => 1,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Posada del Carmen',
            'key' => 'PC',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Posada de los Condes',
            'key' => 'PCD',
            'zone_id' => 4,
        ]);
        DB::table('hotels')->insert([
            'name' => 'Providencia',
            'key' => 'PV',
            'zone_id' => 4,
        ]);
    }
}
