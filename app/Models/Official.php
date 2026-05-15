<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    protected $fillable = [
        'resident_id',
        'official_title_id',
        'term_count'
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function official_title()
    {
        return $this->belongsTo(OfficialTitle::class, 'official_title_id');
    }

    public function certificateDetails()
    {
        return $this->hasMany(CertificateDetail::class, 'official_id');
    }
}
