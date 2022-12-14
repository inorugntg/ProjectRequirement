<?php 
 
use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration 
{ 
    /** 
     * Run the migrations. 
     * 
     * @return void 
     */ 
    public function up() 
    { 
        Schema::create('user', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->string('nama'); 
            $table->string('date'); 
            $table->string('email')->unique(); 
            $table->timestamp('email_verified_at')->nullable(); 
            $table->string('phone'); 
            $table->string('job'); 
            $table->string('skill'); 
            $table->rememberToken(); 
            $table->timestamps(); 
        }); 
    } 
 
    /** 
     * Reverse the migrations. 
     * 
     * @return void 
     */ 
    public function down() 
    { 
        Schema::dropIfExists('users'); 
    } 
}