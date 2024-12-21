<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MentorshipSession extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'coach_id', 'start_time', 'end_time', 'notes', 'meeting_link'];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
