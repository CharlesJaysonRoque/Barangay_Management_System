<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resident;
use Illuminate\Support\Str;

class ResidentSeeder extends Seeder
{
    public function run()
    {
        $streets = ['Baquino', 'Inchano', 'Ciroq'];

        for ($i = 1; $i <= 128; $i++) {
            Resident::create([
                'firstname' => fake()->firstName(),
                'middlename' => fake()->lastName(),
                'lastname' => fake()->lastName(),
                'contact_number' => '09' . rand(100000000, 999999999),
                'street' => $streets[array_rand($streets)],
                'house_number' => 'HSE-' . rand(200, 1200),
            ]);
        }
    }
}
