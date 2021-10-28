<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    public function codes()
    {
        return $this->hasMany('App\Code');
    }

    public function agreements()
    {
        return $this->hasMany('App\Agreement');
    }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function translates()
    {
        return $this->hasMany('App\Translate');
    }

}
