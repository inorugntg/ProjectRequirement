<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
   
    return response()->json([
        'title' => 'FrontEnd Test',
        'company' => 'Energeek The E – Government Solution',
        'address' => 'Jl Baratajaya 3/16, RT 06 RW 04, Surabaya, Jawa Timur',
    ], 200);
});

Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('register', [CustomAuthController::class, 'index'])->name('register');
Route::post('custom-register', [CustomAuthController::class, 'customregister'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::post('register', 'App\Http\Controllers\CustomAuthController@index');
Route::post('custom-register', 'App\Http\Controllers\CustomAuthController@customregister') ->name('register.custom');