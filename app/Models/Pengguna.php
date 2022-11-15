<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class Pengguna extends Model
{
    use HasFactory,
    Notifiable,
    SoftDeletes,
    SoftCascadeTrait,
    Userstamps;

// protected $guard_name = 'api';

protected $fillable = [
    'nama',
    'birth_year',
    'email',
    'phone',
    'job',
    'skill',
    'created_by',
    'updated_by',
    'deleted_by',
];

// protected $hidden = ['password'];

protected $casts = [
    'created_at' => 'string',
    'updated_at' => 'string',
    'deleted_at' => 'string',
];

protected $softCascade = [
    'RegisterModel',
];

public function getJWTIdentifier()
{
    return $this->getKey();
}

public function getJWTCustomClaims()
{
    return [
        'hst' => md5(gethostname()),
        'ipa' => md5(request()->ip()),
        'ura' => md5(request()->userAgent()),
    ];
}

public function Register()
{
    return $this->belongsToMany(Pengguna::class, 'job','skill');
}

public function Pengguna()
{
    return $this->hasMany(Pengguna::class,'job','skill');
}

}
