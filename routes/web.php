<?php

use App\Http\Controllers\ProficiencyUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::controller(ProficiencyUserController::class)->group(function () {
    Route::get('download_client_report/{record}',  'download_client_report')->name('download.client.report');
    Route::get('download_client_certificate/{record}',  'download_client_certificate')->name('download.client.certificate');
});
