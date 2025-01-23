<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{

    use Notifiable;
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // La clé étrangère est 'role_id'
    }
    

// Dans le modèle User
    public function projectsCoached()
    {
        return $this->hasMany(Project::class, 'coach_id');
    }

    public function mentorshipSessions()
{
    return $this->hasMany(MentorshipSession::class, 'coach_id');
}

public function projects()
{
    return $this->hasMany(Project::class, 'user_id');
}
public function receivedMessages(): HasMany
{
    return $this->hasMany(Message::class, 'receiver_id');
}



    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'bio',  
        'fonction',
        'genre',
        'biographie',
        'telephone',
        'ville',
        'date_naissance',
        'instagram',
        'facebook',
        'linkedin',
        'twitter',
        'startup_nom',
        'startup_slogan',
        'expertise',
        'startup_adresse',
        'startup_secteur',
        'experience',
        'pitch',
        'profile_picture', // Pour stocker le chemin de la photo// Ajoute ceci pour que role_id soit pris en compte
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
