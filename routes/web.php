<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchantController;

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
    return view('auth.login');
});

Route::get('/verified', function () {
    return view('verifysuccess');
});


Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth','verified'])->name('dashboard');

Route::group(['middleware' => ['auth','verified']], function(){
    //User
    Route::resource('merchant', MerchantController::class);
    Route::get('/get-merchant', [MerchantController::class, 'get_merchant'])->name('merchant.get-merchant');
});

require __DIR__.'/auth.php';
