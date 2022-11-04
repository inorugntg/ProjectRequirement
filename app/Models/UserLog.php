<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class UserLog extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $fillable = [
        'user_id',
        'url',
        'method',
        'header',
        'request',
        'response',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string',
        'deleted_at' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function saveLog($response = null)
    {
        $user = auth('api')->user();

        $userLog = new UserLog();
        $userLog->user_id = ($user) ? $user->id : null;
        $userLog->url = request()->fullUrl();
        $userLog->method = request()->method();
        $userLog->header = (request()->headers->all()) ? json_encode(request()->headers->all()) : null;
        $userLog->request = (request()->all()) ? json_encode(request()->all()) : null;
        $userLog->response = ($response) ? json_encode($response) : null;
        $userLog->save();

        return $userLog;
    }
}
