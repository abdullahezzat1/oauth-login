<?php

use App\Http\Controllers\GETController;
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

Route::get('/', [GETController::class, 'home']);
Route::get('/google-login', [GETController::class, 'googleLogin']);
Route::get('/facebook-login', [GETController::class, 'facebookLogin']);
Route::get('/github-login', [GETController::class, 'githubLogin']);
Route::get('/profile', [GETController::class, 'profile']);
Route::get('/logout', [GETController::class, 'logout']);
