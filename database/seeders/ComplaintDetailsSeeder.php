<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComplaintDetail;
use App\Models\Resident;
use App\Models\ComplaintType;
use App\Models\Status;

class ComplaintDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residents = Resident::pluck('id')->toArray();
        $types = ComplaintType::pluck('id')->toArray();
        $statuses = Status::pluck('id')->toArray();

        if (empty($residents) || empty($types) || empty($statuses)) {
            return; // safety check
        }

        $complaints = [
            [
                'complainant_id' => $residents[0],
                'accused_id'     => $residents[1] ?? $residents[0],
                'complaint_type_id' => $types[0],
                'status_id'      => $statuses[0],
            ],
            [
                'complainant_id' => $residents[1] ?? $residents[0],
                'accused_id'     => $residents[2] ?? $residents[0],
                'complaint_type_id' => $types[1] ?? $types[0],
                'status_id'      => $statuses[1] ?? $statuses[0],
            ],
            [
                'complainant_id' => $residents[2] ?? $residents[0],
                'accused_id'     => $residents[3] ?? $residents[1] ?? $residents[0],
                'complaint_type_id' => $types[2] ?? $types[0],
                'status_id'      => $statuses[0],
            ],
            [
                'complainant_id' => $residents[0],
                'accused_id'     => $residents[3] ?? $residents[1] ?? $residents[0],
                'complaint_type_id' => $types[3] ?? $types[0],
                'status_id'      => $statuses[1] ?? $statuses[0],
            ],
            [
                'complainant_id' => $residents[1] ?? $residents[0],
                'accused_id'     => $residents[0],
                'complaint_type_id' => $types[4] ?? $types[0],
                'status_id'      => $statuses[0],
            ],
        ];

        foreach ($complaints as $complaint) {
            ComplaintDetail::create($complaint);
        }
    }
}
