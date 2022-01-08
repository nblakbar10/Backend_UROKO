<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\DaftarLelangController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\ManajemenAdminController;
use App\Http\Controllers\PetProfileController;
use App\Http\Controllers\PetActivityController;

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
    Route::resource('lelang', DaftarLelangController::class);

    Route::resource('user', ManajemenUserController::class);
    Route::get('/get-user', [ManajemenUserController::class, 'get_user'])->name('user.get-user');

    Route::resource('admin', ManajemenAdminController::class);
    Route::get('/get-admin', [ManajemenAdminController::class, 'get_admin'])->name('admin.get-admin');

    Route::resource('merchant', MerchantController::class);
    Route::get('/get-merchant', [MerchantController::class, 'get_merchant'])->name('merchant.get-merchant');

    Route::resource('pet-profile', PetProfileController::class);
    Route::get('/get-pet', [PetProfileController::class, 'get_pet'])->name('pet-profile.get-pet');
    Route::get('/get-group', [PetProfileController::class, 'get_group'])->name('pet-profile.get-group');
    
    Route::resource('pet-activity', PetActivityController::class);
    Route::get('/get-activity', [PetActivityController::class, 'get_activity'])->name('pet-activity.get-pet');
    Route::get('/get-group-activity', [PetActivityController::class, 'get_group_activity'])->name('pet-activity.get-group');
});

require __DIR__.'/auth.php';
