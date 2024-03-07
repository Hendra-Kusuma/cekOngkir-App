<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $datakota = file_get_contents(base_path('/database/kota.json'));
        $dataKabupaten = file_get_contents(base_path('/database/kabupaten.json'));
        $kota = json_decode($datakota, true);
        $kabupaten = json_decode($dataKabupaten, true);

        City::insert($kota);
        City::insert($kabupaten);
    }
}
