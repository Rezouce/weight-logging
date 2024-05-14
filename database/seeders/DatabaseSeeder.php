<?php

namespace Database\Seeders;

use App\Models\Weight;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (File::json(database_path('weight.json')) as ['date' => $dateAsString, 'weight' => $weight]) {
            $weight = Weight::firstOrNew(['date' => new Carbon($dateAsString)]);

            $weight->weight = $weight * 100;

            $weight->save();
        }
    }
}
