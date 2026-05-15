<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintType extends Model
{
    protected $fillable = [
        'description'
    ];

    public function complaintDetails()
    {
        return $this->hasMany(ComplaintDetail::class, 'complaint_type_id');
    }
}
