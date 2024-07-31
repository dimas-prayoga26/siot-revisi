<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Uuid;
use App\Models\Admin;
use App\Models\Guest;
use App\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; 
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, Uuid, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    protected $guarded = [];

    // protected $appends = ['name'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guard_name = 'web';

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

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function userData()
    {
        return $this->hasOne(UserData::class);
    }

    public function trashBin()
    {
        return $this->hasOne(TrashBin::class);
    }

    
    public function dueses()
    {
        return $this->hasMany(Dueses::class);
    }

    // protected function getNameAttribute($value)
    // {
    //     return $this->userData->name ?? null;
    // }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
}
