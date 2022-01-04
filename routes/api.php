<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MerchantController;
use App\Http\Controllers\API\PetProfileController;
use App\Http\Controllers\API\PetActivityController;
use App\Http\Controllers\API\PetGroupController;

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

    Route::resource('adoption-item', AdoptionItemController::class);
    //Route::get('/adoption-item/{id}', [AdoptionItemController::class, 'detail_pet'])->name('user.detail-pet');
    
});


require __DIR__.'/auth-api.php';
