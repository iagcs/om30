<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('patient')->controller(\Modules\Patient\app\Http\Controllers\PatientController::class)->group(static function () {
    Route::post('', 'create')->name('patient.create');
    Route::put('/{patient}', 'update')->name('patient.update');
    Route::get('/{patient}', 'show')->name('patient.show');
    Route::delete('/{patient}', 'destroy')->name('patient.destroy');
    Route::middleware('auth:sanctum')->post('import', 'import')->name('patient.import');
});


Route::prefix('address')->controller(\Modules\Patient\app\Http\Controllers\AddressController::class)->group(static function () {
    Route::post('/store/{patient}', 'create')->name('address.create');
    Route::put('/{address}', 'update')->name('address.update');
    Route::get('/{address}', 'show')->name('address.show');
    Route::delete('{address}', 'destroy')->name('address.destroy');
    Route::post('/search-by-cep', 'search')->name('address.search');
});
