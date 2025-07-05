<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $stations = [
            [
                'name' => 'Station 1',
                'location' => 'Lantai 1 - Area Gaming',
                'description' => 'Station gaming utama dengan konsol terbaru dan fasilitas lengkap',
                'is_active' => true
            ],
            [
                'name' => 'Station 2', 
                'location' => 'Lantai 1 - Area VIP',
                'description' => 'Station VIP dengan suasana premium dan privasi lebih',
                'is_active' => true
            ],
            [
                'name' => 'Station 3',
                'location' => 'Lantai 2 - Area Tournament',
                'description' => 'Station khusus untuk tournament dan kompetisi gaming',
                'is_active' => true
            ],
            [
                'name' => 'Station 4',
                'location' => 'Lantai 2 - Area Casual',
                'description' => 'Station santai untuk gaming casual dan keluarga',
                'is_active' => true
            ]
        ];

        foreach ($stations as $stationData) {
            Station::create($stationData);
        }
    }
}