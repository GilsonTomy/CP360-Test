<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web;

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
Route::group(['namespace'=>'Web'],function() {
    /* Login and logout routes */
    Route::get('/', [Web\LoginController::class, 'index'])->middleware('guest')->name('login');
    Route::post('/', [Web\LoginController::class, 'authenticate'])->middleware('guest')->name('web.login.submit');
    Route::post('/logout', [Web\LoginController::class, 'destroy'])->middleware('auth')->name('web.logout');

    /*Routes for dashboard access */
    Route::get('/home', [Web\DashboardController::class, 'index'])->name('web.dashboard');

    /* Routes for forms*/
    Route::get('/forms', [Web\FormsController::class, 'index'])->name('web.forms');
    Route::post('/forms/change-status', [Web\FormsController::class, 'changeStatus'])->name('web.forms.status');
    Route::post('/forms/update-order', [Web\FormsController::class, 'updateOrder'])->name('web.forms.order');
    Route::get('/forms/delete/{id}', [Web\FormsController::class, 'destroy'])->name('web.forms.delete');
    Route::get('/forms/edit/{id}', [Web\FormsController::class, 'edit'])->name('web.forms.edit');
    Route::post('/forms/edit/{id}', [Web\FormsController::class, 'update'])->name('web.forms.update');
    Route::get('/forms/add', [Web\FormsController::class, 'create'])->name('web.forms.create');
    Route::post('/forms/add', [Web\FormsController::class, 'store'])->name('web.forms.store');

    Route::get('/view-form/{slug}', [Web\PublicController::class, 'index'])->name('web.forms.public');
});
