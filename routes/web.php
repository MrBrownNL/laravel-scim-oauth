<?php

use App\Http\Controllers\OauthClientController;
use App\Http\Controllers\OauthTokenController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('clients', OauthClientController::class);
    Route::resource('tokens', OauthTokenController::class, ['except' => ['destroy']]);
    Route::get('tokens/revoke/{oauthClientId}/{oauthToken}', [OauthTokenController::class, 'revoke'])->name('tokens.revoke');
    Route::delete('tokens/destroy/{oauthClientId}/{oauthToken}', [OauthTokenController::class, 'destroy'])->name('tokens.destroy');
});
