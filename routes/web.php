<?php

use App\Http\Controllers\AdminPanelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('adminpanel')->group(function () {
    Route::get('groups', [AdminPanelController::class, 'groups']);
    Route::get('reset', [AdminPanelController::class, 'reset'])->name('counters.reset');
});
