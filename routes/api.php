<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PlanActionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourPlanController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;


Route::post('login', [AuthController::class, 'login']);

Route::post('admin-login', [AdminController::class, 'adminLogin']);

Route::group(['middleware' => 'jwt'], function () {
    Route::post('logout', [AdminController::class, 'logout']);
    Route::post('refresh', [AdminController::class, 'refresh']);
    Route::post('me', [AdminController::class, 'me'])->name('profile');
    Route::post('change-password', [AdminController::class, 'changePass'])->name('changePass');
    Route::get('monthly-plan-list',[HomeController::class,'monthlyPlan'])->name('monthlyPlan');
    Route::post('monthly-plan-list/{ID}', [HomeController::class,'show']);
    Route::get('tour-list',[HomeController::class,'TourList'])->name('TourList');
    Route::get('get-all-dashboard-data', [HomeController::class,'getDashboardAllData']);
    Route::get('export-mdp-list', [HomeController::class,'mdpExport']);

});



Route::group(['middleware' => ['jwt'],'prefix' => 'tour'], function () {
    Route::post('profile-Info', [AuthController::class, 'profileInfo']);
    Route::post('save-plan',[TourPlanController::class,'store']);
    Route::post('update-plan',[TourPlanController::class,'executePlan']);
    Route::get('list',[TourPlanController::class,'tourList']);
    Route::get('action',[TourPlanController::class,'actionTour']);
    Route::get('action-list',[PlanActionController::class,'list']);
});






