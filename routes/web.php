<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardStatController;
use App\Http\Controllers\Admin\AppointmentStatusController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function(){

    Route::get('/api/stats/appointments',[DashboardStatController::class,'appointments']);
    Route::get('/api/stats/users',[DashboardStatController::class,'users']);
    //--------------------------------------------------------//
    Route::get('/api/users', [UserController::class,'index']);
    Route::post('/api/addUser',[UserController::class,'add']);
    Route::delete('/api/users/bulkDelete',[UserController::class, 'bulkDelete']);
    Route::post('/api/updateUser{user}',[UserController::class,'update']);
    Route::delete('/api/deleteUser{user}',[UserController::class,'delete']);
    Route::patch('/api/users/{user}/change-role',[UserController::class,'changeRole']);
    //------------------------------------------------------------//

    Route::get('/api/appointments',[AppointmentController::class,'index']);
    Route::post('/api/appointments/create',[AppointmentController::class,'store']);
    Route::get('/api/appointments/{appointment}/edit',[AppointmentController::class,'edit']);
    Route::put('api/appointments/{appointment}/update',[AppointmentController::class,'update']);
    Route::delete('/api/appointments/{appointment}/delete',[AppointmentController::class,'delete']);
    //---------------------------------------------------------------//
    Route::get('/api/clients',[ClientController::class,'index']);
    Route::get('/api/appointment-status',[AppointmentStatusController::class,'getStatusWithCount']);
    //-------------------------------------------------------------------//
    Route::get('/api/settings',[SettingsController::class,'index']);
    Route::post('/api/settings/update',[SettingsController::class,'update']);
    //--------------------------------------------------------------//
    Route::get('/api/profile',[ProfileController::class,'index']);
    Route::put('/api/profile/update',[ProfileController::class,'update']);
    Route::post('/api/upload-profile-image',[ProfileController::class,'upload_image']);
    Route::post('/api/change-user-password',[ProfileController::class,'changePassword']);
});



Route::get('{vue}', ApplicationController::class)->where('vue','(.*)')->middleware('auth');

