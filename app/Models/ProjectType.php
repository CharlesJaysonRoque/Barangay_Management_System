<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    protected $fillable = [
        'description'
    ];

    public function projects()
    {
        return $this->hasMany(ProjectDetail::class, 'project_type_id');
    }
}
