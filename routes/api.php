<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MerchantController;
use App\Http\Controllers\API\PetProfileController;
use App\Http\Controllers\API\PetActivityController;
use App\Http\Controllers\API\PetGroupController;

use App\Http\Controllers\API\AdoptionItemController;
use App\Http\Controllers\API\AuctionItemController;
use App\Http\Controllers\API\RentItemController;

use App\Http\Controllers\API\AdoptionOrderController;
use App\Http\Controllers\API\RentOrderController;
use App\Http\Controllers\API\AuctionOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api','apiverified']], function(){
    //User
    Route::resource('merchant-user', MerchantController::class);

    Route::resource('pet-profile-user', PetProfileController::class);
    Route::get('/pet-profile-user/detail/{id}', [PetProfileController::class, 'detail_pet'])->name('user.detail-pet');

    
    Route::resource('pet-activity-user', PetActivityController::class);
    Route::get('/pet-activity-user/detail/{id}', [PetActivityController::class, 'detail_activity'])->name('user.detail-activity');
    Route::get('/pet-activity-user/group/{id}', [PetActivityController::class, 'group_activity'])->name('user.group-activity');

    
    Route::resource('pet-group-user', PetGroupController::class);
    Route::get('/pet-group-user/detail/{id}', [PetGroupController::class, 'detail_group'])->name('user.detail-group ');
    // Route::put('petgroup_edit/{id}', [PetGroupController::class, 'petgroup_edit']);

    Route::get('merchant_index', [MerchantController::class, 'merchant_index']);
    Route::post('merchant_post', [MerchantController::class, 'merchant_post']);


    Route::get('adoptionitem_index', [AdoptionItemController::class, 'adoptionitem_index']);
    Route::post('adoptionitem_post/{id}', [AdoptionItemController::class, 'adoptionitem_post']);
    Route::post('adoptionitem_edit/{id}', [AdoptionItemController::class, 'adoptionitem_edit']);
    Route::delete('adoptionitem_delete/{id}', [AdoptionItemController::class, 'adoptionitem_delete']);

    Route::get('auctionitem_index', [AuctionItemController::class, 'auctionitem_index']);
    Route::post('auctionitem_post/{id}', [AuctionItemController::class, 'auctionitem_post']);
    Route::post('auctionitem_edit/{id}', [AuctionItemController::class, 'auctionitem_edit']);
    Route::delete('auctionitem_delete/{id}', [AuctionItemController::class, 'auctionitem_delete']);

    Route::get('rentitem_index', [RentItemController::class, 'rentitem_index']);
    Route::post('rentitem_post/{id}', [RentItemController::class, 'rentitem_post']);
    Route::post('rentitem_edit/{id}', [RentItemController::class, 'rentitem_edit']);
    Route::delete('rentitem_delete/{id}', [RentItemController::class, 'rentitem_delete']);

    Route::get('transaction_index', [TransactionController::class, 'transaction_index']);


    Route::post('adoptionorder_post/{id}', [AdoptionOrderController::class, 'adoptionorder_post']);
    Route::get('adoptionorder_getdetail/{id}', [AdoptionOrderController::class, 'adoptionorder_getdetail']);
    Route::get('adoptionorder_getall', [AdoptionOrderController::class, 'adoptionorder_getall']);

    Route::post('auctionorder_post/{id}', [AuctionOrderController::class, 'auctionorder_post']);

    Route::post('rentorder_post/{id}', [RentOrderController::class, 'rentorder_post']);
});


require __DIR__.'/auth-api.php';
