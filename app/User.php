<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public const ROLE_ADMIN =  'admin';
    public const ROLE_USER = 'user';

    /**
     * @return array
     */
    public static function getRoles()
    {
        return [
            self::ROLE_ADMIN => 1,
            self::ROLE_USER => 2,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function project()
    {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role->title === self::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role->title === self::ROLE_USER;
    }
}
