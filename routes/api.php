<?php


use App\Http\Controllers\Api\CompanyController;
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
    Route::put('companys/{company}', [CompanyController::class, 'updateStatus']);
});
