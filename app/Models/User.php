<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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

    //user 1 a profile 1
    //Un usuario tiene un profile (hasOne). User entidad fuerte
    public function profile(){
        return $this->hasOne('App\Models\Profile');
    }

    //users 1 a posts muchos
    public function posts(){
        return $this->hasMany('App\Models\Post');
    }

    //Muchos a muchos
    //Un usuario tiene muchos roles
    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }

}
