<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            StationSeeder::class,
            SimpleConsoleSeeder::class,
            ConsoleStationSeeder::class,
            GenreSeeder::class,
            GameSeeder::class,
            EventSeeder::class,
            FinalBookingSeeder::class,
        ]);

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
