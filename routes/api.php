<?php

use App\Http\Controllers\Api\Admin\RoleAndPermissionController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\school\SchoolController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\Api\work\WorkController;
use App\Http\Controllers\Api\work\WorkerController;
use App\Http\Controllers\Api\work\WorkerrateController;
use App\Http\Controllers\DoctorclinicController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
////////////////////register routes////////////////
Route::post('/register',[RegisterController::class,'register']);
Route::post('/login',[LoginController::class,'login']);


Route::middleware(['auth:sanctum'])->group(function(){

    ///////////////////////manage of Roles////////////////////
    Route::post('/storeRole',[RoleAndPermissionController::class,'store']);
    Route::delete('/destroyRole/{role}',[RoleAndPermissionController::class,'destroy']);
    Route::get('/allroles',[RoleAndPermissionController::class,'index']);
    Route::get('/allpermissions',[RoleAndPermissionController::class,'allpermissions']);
    Route::get('/editrole/{role}',[RoleAndPermissionController::class,'editerole']);
    Route::patch('/updaterole/{id}',[RoleAndPermissionController::class,'updaterole']);

    ///////////////////works////////////////////////////////
    Route::resource('/works',WorkController::class);
    /////////////////workers////////////////////
    Route::resource('/workers',WorkerController::class);
    Route::post('/rateworker/{worker}',[WorkerrateController::class,'update']);

    Route::post('/storedoctor',[DoctorclinicController::class,'store']);
    Route::resource('/teachers',TeacherController::class);

    Route::resource('/schools',SchoolController::class);

    //////////////////clinics////////////////////
    Route::resource('/clinics',ClinicController::class);
});
Route::get('/allworks',[WorkController::class,'index']);
Route::get('/showworks/{work}',[WorkController::class,'show']);
Route::get('/allclinics',[ClinicController::class,'index']);
Route::get("/showclinic/{id}",[ClinicController::class,'show']);
Route::get('/allworkers',[WorkerController::class,'index']);

Route::get('/allschools',[SchoolController::class,'index']);
Route::get('/showschool/{school}',[SchoolController::class,'show']);
Route::get('/allteacher',[TeacherController::class,'index']);


////////////////////Password reset////////////////
Route::post('password/forget',[ForgetPasswordController::class,'forgetPassword']);
Route::post('password/reset',[ResetPasswordController::class,'resetPassword']);
