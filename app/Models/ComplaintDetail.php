<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintDetail extends Model
{
    protected $fillable = [
        'complainant_id',
        'accused_id',
        'complaint_type_id',
        'status_id'
    ];

    public function complainant()
    {
        return $this->belongsTo(Resident::class, 'complainant_id');
    }

    public function accused()
    {
        return $this->belongsTo(Resident::class, 'accused_id');
    }

    public function complaintType()
    {
        return $this->belongsTo(ComplaintType::class, 'complaint_type_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
