<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    protected $fillable = [
        'fine_id',
        'resident_id',
        'status_id'
    ];

    public function fine() {
        return $this->belongsTo(Fine::class, 'fine_id');
    }

    public function resident() {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
