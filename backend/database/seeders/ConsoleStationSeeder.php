<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Console;
use App\Models\Station;

class ConsoleStationSeeder extends Seeder
{
    public function run(): void
    {
        $stations = Station::all();
        $consoles = Console::all();
        
        if ($stations->isEmpty() || $consoles->isEmpty()) {
            return;
        }

        // Distribute consoles across stations
        // Station 1: First 8 consoles
        $station1 = $stations->where('name', 'Station 1')->first();
        $station1Consoles = $consoles->take(8);
        $station1->consoles()->attach($station1Consoles->pluck('id'));

        // Station 2: Next 8 consoles  
        $station2 = $stations->where('name', 'Station 2')->first();
        $station2Consoles = $consoles->skip(8)->take(8);
        $station2->consoles()->attach($station2Consoles->pluck('id'));

        // Station 3: Next 8 consoles
        $station3 = $stations->where('name', 'Station 3')->first();
        $station3Consoles = $consoles->skip(16)->take(8);
        $station3->consoles()->attach($station3Consoles->pluck('id'));

        // Station 4: Remaining consoles
        $station4 = $stations->where('name', 'Station 4')->first();
        $station4Consoles = $consoles->skip(24);
        $station4->consoles()->attach($station4Consoles->pluck('id'));
    }
}