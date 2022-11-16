<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\RecruitmentApiController;
use App\Http\Controllers\Api\SelectListApiController;
use App\Http\Controllers\Api\ShowFileApiController;
use App\Http\Controllers\Api\C_AuthApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth
// Route::group(['prefix' => 'auth', 'middleware' => ['api']], function () {
//     Route::post('/login', [AuthApiController::class, 'login']);
//     Route::get('/check_token_valid', [AuthApiController::class, 'checkTokenIsValid']);

//     Route::group(['middleware' => ['jwt.auth', 'jwt.restrict']], function () {
//         Route::post('logout', [AuthApiController::class, 'logout']);
//         Route::post('refresh', [AuthApiController::class, 'refresh']);
//         Route::get('me', [AuthApiController::class, 'me']);
//     });
// });

//Select List
Route::group(['prefix' => 'select_list', 'middleware' => ['api']], function () {
    Route::get('/job', [SelectListApiController::class, 'job']);
    Route::get('/skill', [SelectListApiController::class, 'skill']);
});

//Show File
Route::group(['prefix' => 'show_file', 'middleware' => ['api']], function () {
    Route::get('/{category}/{id}', [ShowFileApiController::class, 'index']);
});

//Recruitment
Route::group(['prefix' => 'recruitment', 'middleware' => ['api']], function () {
    Route::post('/', [RecruitmentApiController::class, 'store']);
    Route::post('/upload_file', [RecruitmentApiController::class, 'uploadFile']);
});


Route::group(['prefix' => 'C_AuthController', 'middleware' => ['api']], function () {
    Route::get('/register', [C_AuthApiController::class,'pengguna']);
    Route::post('/custom-register', [C_AuthApiController::class, 'customregister']);
});

Route::prefix('C_AuthController')->group(function () {
    Route::get('apiwithoutkey', [ProjectController::class, 'pengguna'])->name('pengguna');
    Route::get('apiwithkey', [ProjectController::class, 'customregister'])->name('customregister');
});

Route::resource('Pengguna', C_AuthApiController::class);
// Routr::group(['prefix' => '/data'])