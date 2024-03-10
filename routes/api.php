<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::controller(AuthenticateController::class)->prefix('auth')->group(function(){
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

    Route::middleware(['auth:sanctum'])->group(function(){
        Route::controller(UserController::class)->prefix('user')->group(function(){
            Route::get('/users', 'index');
            Route::get('/users/{id}', 'show');

            Route::post('/users', 'store');
            Route::put('/users/{id}', 'update')->middleware('auth:api');

            Route::delete('/users/{id}', 'destroy')->middleware(['is.admin']);
        });

        Route::controller(AdminController::class)->prefix('admin')->middleware(['is.admin'])->group(function(){
            Route::get('/user/all', 'allUsers');
            Route::get('/user/one/{user}', 'getOneUser');

            Route::post('/user/create', 'createUser');
            Route::post('/user/edit/{user}', 'updateUser');

            Route::delete('/user/delete/{user}', 'deleteUser');
        });
    });
});
