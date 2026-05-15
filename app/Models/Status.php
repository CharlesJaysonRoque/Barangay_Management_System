<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'description'
    ];

    public function complaints()
    {
        return $this->hasMany(ComplaintDetail::class, 'status_id');
    }

    public function transactions()
    {
        return $this->hasMany(TransactionDetail::class, 'status_id');
    }

    public function violations()
    {
        return $this->hasMany(Violation::class, 'status_id');
    }

    public function projectDetails()
    {
        return $this->hasMany(ProjectDetail::class, 'status_id');
    }
}
