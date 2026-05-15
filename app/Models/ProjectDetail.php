<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    protected $fillable = [
        'project_type_id',
        'description',
        'start_date',
        'tentative_end_date',
        'actual_end_date',
        'budget',
        'status_id'
    ];

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }

    public function project()
    {
        return $this->belongsTo(ProjectType::class, 'project_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
