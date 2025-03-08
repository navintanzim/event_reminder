<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::check()){
            return redirect('/dashboard');
        }else{
            return view('welcome');
        }
        
    });



Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('registration');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('/logout', [CustomAuthController::class, 'signOut'])->name('logout');
Route::get('/notifications/count', [CustomAuthController::class, 'notificationCount']);
Route::get('/single-notification/{id}', [CustomAuthController::class, 'notificationSingle']);
Route::get('/notification-all', [CustomAuthController::class, 'notificationAll']);
Route::get('/notifications/show', [CustomAuthController::class, 'notifications']);