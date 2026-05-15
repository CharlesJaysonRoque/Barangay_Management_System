<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'contact_number',
        'street',
        'house_number'
    ];

    public function accused()
    {
        return $this->hasMany(ComplaintDetail::class, 'accused_id');
    }

    public function complainant()
    {
        return $this->hasMany(ComplaintDetail::class, 'complainant_id');
    }

    public function officials()
    {
        return $this->hasMany(Official::class, 'resident_id');
    }

    public function violation()
    {
        return $this->hasMany(Violation::class, 'resident_id');
    }
}
