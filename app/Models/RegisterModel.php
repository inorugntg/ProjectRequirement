<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegisterModel extends Model
{
    use HasFactory, Notifiable;
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

    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string',
        'deleted_at' => 'string',
    ];

    public function Pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'job', 'skill');
    }

    protected $table='register';
    public $timestamps='false';

    public function alldata(){
        return DB::table('register')->get();
    }
}