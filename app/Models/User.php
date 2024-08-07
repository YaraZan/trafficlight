<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return optional($this->role)->name === 'admin';
    }

    public function isTrainer(): bool
    {
        return $this->isAdmin() || optional($this->role)->name === 'trainer';
    }

    public function isClaimModerator(): bool
    {
        return $this->isAdmin() || optional($this->role)->name === 'Координатор изменений в работе скважины';
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function refClaims()
    {
        return $this->hasMany(RefClaim::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class, 'ngdu_id');
    }

    public function viewAllWells(): bool
    {
        return optional($this->role)->canViewAll;
    }

    public function canEdit(): bool
    {
        return optional($this->role)->canEdit;
    }
}
