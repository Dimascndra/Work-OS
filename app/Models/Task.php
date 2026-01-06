<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function project()
    {
        // Assuming Project model exists or will exist.
        return $this->belongsTo(Project::class);
    }
}
