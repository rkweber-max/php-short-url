<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlManager;

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


Route::post('/short-url', [UrlManager::class, 'createShortUrl'])->name('url.short');
Route::get("/{code}", [UrlManager::class, 'redirectToOriginalUrl'])->name('url.redirect');
Route::get('/stats/{code}', [App\Http\Controllers\UrlManager::class, 'stats'])->name('url.stats');
