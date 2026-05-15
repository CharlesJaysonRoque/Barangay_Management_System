<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'amount',
        'description'
    ];

    public function violation() {
        return $this->hasMany(Violation::class, 'fine_id');
    }
}
