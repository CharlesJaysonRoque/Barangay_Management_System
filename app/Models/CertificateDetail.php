<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateDetail extends Model
{
    protected $fillable = [
        'certificate_type_id',
        'official_id'
    ];

    public function certificateType()
    {
        return $this->belongsTo(CertificateType::class, 'certificate_type_id');
    }

    public function official()
    {
        return $this->belongsTo(Official::class, 'official_id');
    }
}
