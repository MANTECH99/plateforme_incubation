<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'coach_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function coaches()
    {
        return $this->belongsToMany(User::class, 'coach_project', 'project_id', 'coach_id');
    }

    public function mentorshipSessions()
{
    return $this->hasMany(MentorshipSession::class);
}



}
