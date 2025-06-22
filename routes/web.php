<?php

use App\Http\Controllers\UserListController;
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

Route::get('/', [UserListController::class, 'index']);

// AJAX-экспорт пользователей по шагам
Route::post('/user-list/export', [UserListController::class, 'export'])->name('user-list.export');
Route::get('/export/download/{filename}', [UserListController::class, 'download']);
