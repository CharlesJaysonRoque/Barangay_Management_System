<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficialTitle extends Model
{
    protected $fillable = [
        'term_validity',
        'max_term',
        'title'
    ];

    public function officials()
    {
        return $this->hasMany(Official::class, 'official_title_id');
    }
}
