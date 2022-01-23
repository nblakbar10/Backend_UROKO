<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DaftarLelangController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\ManajemenAdminController;
use App\Http\Controllers\PetProfileController;
use App\Http\Controllers\PetActivityController;
use App\Http\Controllers\AdoptionItemController;
use App\Http\Controllers\AdoptionOrderController;
use App\Http\Controllers\AuctionItemController;
use App\Http\Controllers\AuctionOrderController;
use App\Http\Controllers\RentItemController;
use App\Http\Controllers\RentOrderController;
use App\Http\Controllers\PetHotelProviderController;

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

Route::group(['middleware' => ['auth','verified']], function(){
    Route::resource('dashboard', DashboardController::class);
    Route::get('/all-activity', [DashboardController::class, 'all_activity']);

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
    
    Route::resource('adoption-item', AdoptionItemController::class);
    Route::get('/get-adoption-item', [AdoptionItemController::class, 'get_adoption_item'])->name('adoption-item.get-adoption-item');
    
    Route::resource('adoption-order', AdoptionOrderController::class);
    Route::get('/get-adoption-order', [AdoptionOrderController::class, 'get_adoption_order'])->name('adoption-order.get-adoption-order');
    
    Route::resource('auction-item', AuctionItemController::class);
    Route::get('/get-auction-item', [AuctionItemController::class, 'get_auction_item'])->name('auction-item.get-auction-item');
    
    Route::resource('auction-order', AuctionOrderController::class);
    Route::get('/get-auction-order', [AuctionOrderController::class, 'get_auction_order'])->name('auction-order.get-auction-order');
    
    Route::resource('rent-item', RentItemController::class);
    Route::get('/get-rent-item', [RentItemController::class, 'get_rent_item'])->name('rent-item.get-rent-item');
    
    Route::resource('rent-order', RentOrderController::class);
    Route::get('/get-rent-order', [RentOrderController::class, 'get_rent_order'])->name('rent-order.get-rent-order');
    
    Route::resource('pet-hotel-provider', PetHotelProviderController::class);
    Route::get('/get-pet-hotel-provider', [PetHotelProviderController::class, 'get_pet_hotel_provider'])->name('pet-hotel-provider.get-pet-hotel-provider');
    Route::get('/get-merchant-for-hotel-provider', [PetHotelProviderController::class, 'get_merchant_for_hotel_provider'])->name('pet-hotel-provider.get-merchant-for-hotel-provider');
});

require __DIR__.'/auth.php';
