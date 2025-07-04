<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Console;

class ConsoleSeeder extends Seeder
{
    public function run(): void
    {
        $consoles = [
            [
                'name' => 'PlayStation 5 - Station 1',
                'type' => 'ps5',
                'hourly_rate' => 35000,
                'specifications' => [
                    'storage' => '825GB SSD',
                    'controllers' => 2,
                    'features' => ['4K Gaming', 'Ray Tracing', '3D Audio']
                ]
            ],
            [
                'name' => 'PlayStation 5 - Station 2',
                'type' => 'ps5',
                'hourly_rate' => 35000,
                'specifications' => [
                    'storage' => '825GB SSD',
                    'controllers' => 2,
                    'features' => ['4K Gaming', 'Ray Tracing', '3D Audio']
                ]
            ],
            [
                'name' => 'PlayStation 4 Pro - Station 1',
                'type' => 'ps4',
                'hourly_rate' => 25000,
                'specifications' => [
                    'storage' => '1TB HDD',
                    'controllers' => 2,
                    'features' => ['4K Gaming', 'HDR']
                ]
            ],
            [
                'name' => 'PlayStation 4 Pro - Station 2',
                'type' => 'ps4',
                'hourly_rate' => 25000,
                'specifications' => [
                    'storage' => '1TB HDD',
                    'controllers' => 2,
                    'features' => ['4K Gaming', 'HDR']
                ]
            ],
            [
                'name' => 'PlayStation 3 - Station 1',
                'type' => 'ps3',
                'hourly_rate' => 15000,
                'specifications' => [
                    'storage' => '500GB HDD',
                    'controllers' => 2,
                    'features' => ['Blu-ray', 'Backwards Compatible']
                ]
            ]
        ];

        foreach ($consoles as $console) {
            Console::create($console);
        }
    }
}
