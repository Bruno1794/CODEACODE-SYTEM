<?php


use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\CFOPController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\NCMController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use \App\Http\Controllers\Api\NaturezaOperacaoController;

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
    Route::put('update-password/{user}', [UserController::class, 'updatePassword']);

    ##Setting
    Route::get('settings', [SettingController::class, 'show']);
    Route::put('settings/{settingNf}', [SettingController::class, 'update']);

    ##Certificado
    Route::post('certificates/{company}', [CertificateController::class, 'store']);

    ##NCMS
    Route::get('ncm', [NCMController::class, 'index']);
    Route::post('ncm', [NCMController::class, 'store']);
    Route::put('ncm/{ncm}', [NCMController::class, 'update']);

    ##NATUREZA DE OPERAÇÕES
    Route::get('natureza', [NaturezaOperacaoController::class, 'index']);
    Route::post('natureza', [NaturezaOperacaoController::class, 'store']);
    Route::put('natureza/{naturezaOperacao}', [NaturezaOperacaoController::class, 'update']);
    Route::put('natureza-status/{naturezaOperacao}', [NaturezaOperacaoController::class, 'updateStatus']);

    ##CFOP
    Route::get('cfop', [CFOPController::class, 'index']);
    Route::post('cfop', [CFOPController::class, 'store']);
    Route::put('cfop/{cfop}', [CFOPController::class, 'update']);
    Route::put('cfop-status/{cfop}', [CFOPController::class, 'updateSatus']);
});
