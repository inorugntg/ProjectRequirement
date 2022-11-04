<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class Candidate extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_year',
        'job_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string',
        'deleted_at' => 'string',
    ];

    protected $softCascade = [
        'uploads',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_sets', 'candidate_id', 'skill_id');
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class, 'candidate_id', 'id');
    }
}
