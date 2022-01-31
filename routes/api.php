<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MerchantController;
use App\Http\Controllers\API\PetProfileController;
use App\Http\Controllers\API\PetGalleryController;
use App\Http\Controllers\API\PetActivityController;
use App\Http\Controllers\API\PetGroupController;
use App\Http\Controllers\API\TransactionController;

use App\Http\Controllers\API\ManajemenUserController;

use App\Http\Controllers\API\AdoptionItemController;
use App\Http\Controllers\API\AuctionItemController;
use App\Http\Controllers\API\RentItemController;

use App\Http\Controllers\API\AdoptionOrderController;
use App\Http\Controllers\API\RentOrderController;
use App\Http\Controllers\API\AuctionOrderController;

use App\Http\Controllers\API\UserFollowController;

use App\Http\Controllers\API\ShippingController;

use App\Http\Controllers\API\PetHotelOrderController;
use App\Http\Controllers\API\PetHotelProviderController;

use App\Http\Controllers\API\ItemController;


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
    Route::get('/all-transaction-index', [TransactionController::class, 'get_all_transaction']) ;
    Route::get('/all-merchant-order/{merchant_id}', [TransactionController::class, 'get_merchant_order']) ;
    Route::post('/confirm-order/{order_id}/{order_type}', [TransactionController::class, 'confirm_order']) ;
    Route::post('/reject-order/{order_id}/{order_type}', [TransactionController::class, 'reject_order']) ;
    Route::post('/confirm-hotel-order/{order_id}', [TransactionController::class, 'confirm_hotel_order']) ;
    Route::post('/reject-hotel-order/{order_id}', [TransactionController::class, 'reject_hotel_order']) ;
    //User
    Route::post('/manajemen-profile-update', [ManajemenUserController::class, 'update_user_profile']);
    Route::get('/user-profile-detail/{user_id}', [ManajemenUserController::class, 'get_detail_user']);
    Route::delete('/manajemen-profile-delete', [ManajemenUserController::class, 'delete_user_profile']);

    Route::resource('merchant-user', MerchantController::class);

    Route::resource('pet-profile-user', PetProfileController::class);
    Route::get('/pet-profile-user/detail/{id}', [PetProfileController::class, 'detail_pet'])->name('user.detail-pet');
    Route::post('/pet-profile-status/{pet_id}', [PetProfileController::class, 'pet_status_change']);
    Route::get('/pet-profile-another-user/{owner_id}', [PetProfileController::class, 'pet_profile_for_another_user']);

    Route::get('/pet-gallery-index/', [PetGalleryController::class, 'get_album']);
    Route::get('/pet-gallery-index/{album_id}', [PetGalleryController::class, 'get_gallery_by_album_id']);
    Route::post('/pet-gallery-post', [PetGalleryController::class, 'post_album']);
    Route::post('/pet-gallery-edit/{pet_id}/{album_id}', [PetGalleryController::class, 'insert_pet_to_album']);
    Route::get('/pet-gallery-download-image/{image_name}', [PetGalleryController::class, 'download_image_from_gallery']);
    

    // Route::resource('pet-activity-user', PetActivityController::class);
    Route::get('/pet-activity-index', [PetActivityController::class, 'pet_activity_by_user']);
    Route::get('/pet-activity-index/{group_id}', [PetActivityController::class, 'pet_activity_by_group']);
    Route::get('/pet-activity-index/{group_id}/{pet_id}/', [PetActivityController::class, 'pet_activity_by_petid']);
    Route::post('post_pet_activity/{pet_id}', [PetActivityController::class, 'post_pet_activity']);
    Route::post('/pet-activity-update/{id}/', [PetActivityController::class, 'update_pet_activity']);
    Route::delete('/pet-activity-delete/{id}/', [PetActivityController::class, 'delete_pet_activity']);
    //like_comment
    Route::get('/like-comment-pet-activity-index/{activity_id}/', [PetActivityController::class, 'get_activities_likes_comments']);
    Route::post('/like-pet-activity-post/{activity_id}/', [PetActivityController::class, 'post_activities_likes']);
    Route::delete('/like-pet-activity-delete/{like_id}/', [PetActivityController::class, 'delete_activities_likes']);
    Route::post('/comment-pet-activity-post/{activity_id}/', [PetActivityController::class, 'post_activities_comments']);
    Route::post('/comment-pet-activity-edit/{comment_id}/', [PetActivityController::class, 'edit_activities_comments']);
    Route::delete('/comment-pet-activity-delete/{comment_id}/', [PetActivityController::class, 'delete_activities_comments']);
    // Route::get('/pet-activity/detail/{id}', [PetActivityController::class, 'detail_activity']);
    // Route::get('/pet-activity/group/{id}', [PetActivityController::class, 'group_activity'])->name('user.group-activity');

    
    Route::resource('pet-group-user', PetGroupController::class);
    Route::get('/pet-group-user/detail/{id}', [PetGroupController::class, 'detail_group'])->name('user.detail-group ');
    // Route::put('petgroup_edit/{id}', [PetGroupController::class, 'petgroup_edit']);

    Route::get('merchant_index', [MerchantController::class, 'merchant_index']);
    Route::post('merchant_post', [MerchantController::class, 'merchant_post']);
    Route::post('merchant_update', [MerchantController::class, 'merchant_update']);
    Route::delete('merchant_delete', [MerchantController::class, 'merchant_delete']);


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

    Route::post('adoptionorder_post/{id}', [AdoptionOrderController::class, 'adoptionorder_post']);
    Route::get('adoptionorder_getdetail/{id}', [AdoptionOrderController::class, 'adoptionorder_getdetail']);
    Route::get('adoptionorder_getall', [AdoptionOrderController::class, 'adoptionorder_getall']);
    Route::post('adoptionorder_cancel/{id}', [AdoptionOrderController::class, 'adoptionorder_cancel']);

    Route::post('auctionorder_post/{id}', [AuctionOrderController::class, 'auctionorder_post']);
    Route::get('auctionorder_getdetail/{id}', [AuctionOrderController::class, 'auctionorder_getdetail']);
    Route::get('auctionorder_getall', [AuctionOrderController::class, 'auctionorder_getall']);
    Route::post('auctionorder_cancel/{id}', [AuctionOrderController::class, 'auctionorder_cancel']);

    Route::post('rentorder_post/{id}', [RentOrderController::class, 'rentorder_post']);
    Route::get('rentorder_getdetail/{id}', [RentOrderController::class, 'rentorder_getdetail']);
    Route::get('rentorder_getall', [RentOrderController::class, 'rentorder_getall']);
    Route::post('rentorder_cancel/{id}', [RentOrderController::class, 'rentorder_cancel']);

    Route::post('post_follow/{id}', [UserFollowController::class, 'post_follow']);
    Route::delete('post_unfollow/{id}', [UserFollowController::class, 'post_unfollow']);
    Route::get('get_all_following', [UserFollowController::class, 'get_all_following']);
    Route::get('get_all_follower', [UserFollowController::class, 'get_all_follower']);

    Route::get('transaction_index', [TransactionController::class, 'transaction_index']);

    Route::post('shipping_post', [ShippingController::class, 'shipping_post']);
    Route::get('get_shipping_option', [ShippingController::class, 'get_shipping_option']);

    Route::post('pethotel_order_post/{id}', [PetHotelOrderController::class, 'pethotel_order_post']);
    Route::get('pethotel_order_getall', [PetHotelOrderController::class, 'pethotel_order_getall']);
    Route::post('pethotel_order_cancel/{id}', [PetHotelOrderController::class, 'pethotel_order_cancel']);

    Route::get('pet_hotel_provider_index', [PetHotelProviderController::class, 'pet_hotel_provider_index']);
    Route::post('pet_hotel_provider_post', [PetHotelProviderController::class, 'pet_hotel_provider_post']);
    Route::post('pet_hotel_provider_update', [PetHotelProviderController::class, 'pet_hotel_provider_update']);
    Route::delete('pet_hotel_provider_delete', [PetHotelProviderController::class, 'pet_hotel_provider_delete']);

    Route::post('pet_hotel_provider_fee_post/{pet_hotel_provider_id}', [PetHotelProviderController::class, 'pet_hotel_provider_fee_post']);
    Route::post('pet_hotel_provider_fee_update/{id}', [PetHotelProviderController::class, 'pet_hotel_provider_fee_update']);
    Route::delete('pet_hotel_provider_fee_delete/{id}', [PetHotelProviderController::class, 'pet_hotel_provider_fee_delete']);

    Route::post('pet_hotel_provider_amminities_post/{pet_hotel_provider_id}', [PetHotelProviderController::class, 'pet_hotel_provider_amminities_post']);
    Route::post('pet_hotel_provider_amminities_update/{id}', [PetHotelProviderController::class, 'pet_hotel_provider_amminities_update']);
    Route::delete('pet_hotel_provider_amminities_delete/{id}', [PetHotelProviderController::class, 'pet_hotel_provider_amminities_delete']);

    Route::post('pet_hotel_provider_amminities_extra_post/{pet_hotel_provider_id}', [PetHotelProviderController::class, 'pet_hotel_provider_amminities_extra_post']);
    Route::post('pet_hotel_provider_amminities_extra_update/{id}', [PetHotelProviderController::class, 'pet_hotel_provider_amminities_extra_update']);
    Route::delete('pet_hotel_provider_amminities_extra_delete/{id}', [PetHotelProviderController::class, 'pet_hotel_provider_amminities_extra_delete']);

    Route::get('adoptionitem_all', [ItemController::class, 'adoptionitem_all']);
    Route::get('auctionitem_all', [ItemController::class, 'auctionitem_all']);
    Route::get('rentitem_all', [ItemController::class, 'rentitem_all']);
    Route::get('pet_hotel_provider_all', [ItemController::class, 'pet_hotel_provider_all']);
});


require __DIR__.'/auth-api.php';
