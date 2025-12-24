<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    public function run()
    {
        Platform::create(['name' => 'X', 'type' => 'x']);
        Platform::create(['name' => 'Instagram', 'type' => 'instagram']);
        Platform::create(['name' => 'LinkedIn', 'type' => 'linkedin']);
        Platform::create(['name' => 'FACEBOOK', 'type' => 'facebook']);
    }
}