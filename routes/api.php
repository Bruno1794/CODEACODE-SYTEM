<?php


use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;

## Login
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
##Logout
    Route::post('/logout', [LoginController::class, 'logout']);

    ##Company
    Route::get('companys', [CompanyController::class, 'index']);
    Route::post('companys', [CompanyController::class, 'post']);
    Route::get('companys-users/{company}', [CompanyController::class, 'indexUsers']);
    Route::put('companys/{company}', [CompanyController::class, 'update']);
    Route::put('companys-status/{company}', [CompanyController::class, 'updateStatus']);
    Route::put('companys-renew/{company}', [CompanyController::class, 'updateDataExpiration']);

    ##Usuario
    Route::put('update-password/{user}',[UserController::class, 'updatePassword']);

});
