<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class Pengguna extends Authenticatable implements JWTSubject
{
    use HasFactory,
    Notifiable,
    SoftDeletes,
    SoftCascadeTrait,
    Userstamps;

protected $guard_name = 'api';

protected $fillable = [
    'nama',
    'date',
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
    'user_logs',
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

public function user_logs()
{
    return $this->hasMany(UserLog::class, 'user_id', 'id');
}
}
