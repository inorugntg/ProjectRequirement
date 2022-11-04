<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegisterModel extends Model
{
    protected $table='register';
    public $timestamps='false';

    public function alldata(){
        return DB::table('register')->get();
    }

    public function uploads(){
        return DB::table('register')->insert($data);
    }
}