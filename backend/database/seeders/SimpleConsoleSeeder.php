<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Console;

class SimpleConsoleSeeder extends Seeder
{
    public function run(): void
    {
        Console::query()->delete();

        $consoles = [
            ['name' => 'PlayStation 5 Pro #1', 'type' => 'ps5', 'hourly_rate' => 25000, 'status' => 'available', 'specifications' => ['storage' => '1TB SSD', 'controllers' => '2 DualSense', 'features' => ['4K Gaming', 'Ray Tracing', 'HDR', '3D Audio']], 'is_active' => true],
            ['name' => 'PlayStation 5 Standard #1', 'type' => 'ps5', 'hourly_rate' => 22000, 'status' => 'available', 'specifications' => ['storage' => '825GB SSD', 'controllers' => '2 DualSense', 'features' => ['4K Gaming', 'Ray Tracing', 'HDR']], 'is_active' => true],
            ['name' => 'PlayStation 5 Digital #1', 'type' => 'ps5', 'hourly_rate' => 20000, 'status' => 'available', 'specifications' => ['storage' => '825GB SSD', 'controllers' => '2 DualSense', 'features' => ['4K Gaming', 'Digital Only']], 'is_active' => true],
            ['name' => 'PlayStation 4 Pro #1', 'type' => 'ps4', 'hourly_rate' => 18000, 'status' => 'available', 'specifications' => ['storage' => '1TB HDD', 'controllers' => '2 DualShock 4', 'features' => ['4K Support', 'HDR', 'VR Ready']], 'is_active' => true],
            ['name' => 'PlayStation 4 Slim #1', 'type' => 'ps4', 'hourly_rate' => 15000, 'status' => 'available', 'specifications' => ['storage' => '500GB HDD', 'controllers' => '2 DualShock 4', 'features' => ['Full HD', 'HDR']], 'is_active' => true],
            ['name' => 'PlayStation 3 Super Slim #1', 'type' => 'ps3', 'hourly_rate' => 12000, 'status' => 'available', 'specifications' => ['storage' => '500GB HDD', 'controllers' => '2 DualShock 3', 'features' => ['Full HD', 'Blu-ray']], 'is_active' => true],
            ['name' => 'PlayStation 3 Slim #1', 'type' => 'ps3', 'hourly_rate' => 10000, 'status' => 'available', 'specifications' => ['storage' => '320GB HDD', 'controllers' => '2 DualShock 3', 'features' => ['HD Gaming', 'Blu-ray']], 'is_active' => true],
        ];

        foreach ($consoles as $consoleData) {
            Console::create($consoleData);
        }
    }
}