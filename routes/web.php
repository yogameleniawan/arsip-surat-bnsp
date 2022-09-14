<?php

use App\Http\Controllers\ArsipController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', function () {
    return redirect()->route('arsip.index');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', function() {
        return view('admin.profile.index');
    })->name('profile');

    Route::resources([
        'arsip' => ArsipController::class,
    ]);
});
