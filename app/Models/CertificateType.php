<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateType extends Model
{
    protected $fillable = [
        'description'
    ];

    public function certificateDetails()
    {
        return $this->hasMany(CertificateDetail::class, 'certificate_type_id');
    }
}
