<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComplaintType;

class ComplaintTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Noise Disturbance',
            'Illegal Parking',
            'Physical Assault',
            'Littering / Garbage Disposal Violation',
            'Public Disturbance',
        ];

        foreach ($types as $type) {
            ComplaintType::create([
                'description' => $type,
            ]);
        }
    }
}
