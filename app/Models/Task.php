<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    protected $fillable = [
        'title',
        'description',
        'to_do_file', // Fichier du travail à effectuer
        'status',
        'due_date',
        'project_id',
        'is_completed',
        'submission', // Ajout de cette ligne
    ];
    // app/Models/Task.php
    protected $casts = [
        'due_date' => 'date',
    ];

}

