<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Response;
use App\Models\User;
use App\Models\AdoptionItem;
use App\Models\RentItem;
use App\Models\AuctionItem;
use App\Models\PetHotelProvider;
use App\Models\PetProfile;
use App\Models\Merchant;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function adoptionitem_all()
    {
        $adoptionitem = AdoptionItem::get();

        $adoptionitemjoin = Adoptionitem::leftjoin('users','users.id', 'adoption_item.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_item.pet_id')
        ->leftjoin('merchant','merchant.id', 'adoption_item.merchant_id')
        ->select('adoption_item.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name', 'merchant.merchant_image')
        ->where('adoption_item.user_id', Auth::user()->id) //ini buat get semua itemnya
        ->get();
        // dd($adoptionitemjoin);

        $data = [
            'message' => 'Success',
            'data' => $adoptionitemjoin
        ];     

        return response()->json($data, 200);
    }

    public function auctionitem_all()
    {
        $auctionitem = AuctionItem::get();

        $auctionitemjoin = Auctionitem::leftjoin('users','users.id', 'auction_item.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'auction_item.pet_id')
        ->leftjoin('merchant','merchant.id', 'auction_item.merchant_id')
        ->select('auction_item.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name', 'merchant.merchant_image')
        ->where('auction_item.user_id', Auth::user()->id) //ini buat get semua itemnya
        ->get();
        // dd($auctionitemjoin);

        $data = [
            'message' => 'Success',
            'data' => $auctionitemjoin
        ];     

        return response()->json($data, 200);
    }

    public function rentitem_all()
    {
        $rentitem = RentItem::get();

        $rentitemjoin = Rentitem::leftjoin('users','users.id', 'rent_item.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'rent_item.pet_id')
        ->leftjoin('merchant','merchant.id', 'rent_item.merchant_id')
        ->select('rent_item.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name', 'merchant.merchant_image')
        ->where('rent_item.user_id', Auth::user()->id) //ini buat get semua itemnya
        ->get();
        // dd($rentitemjoin);

        $data = [
            'message' => 'Success',
            'data' => $rentitemjoin
        ];     

        return response()->json($data, 200);
    }

    public function pet_hotel_provider_all()
    {
        $pet_hotel_provider = PetHotelProvider::get();
        
        $feejoin = PetHotelProvider::leftjoin('pet_hotel_provider_fee','pet_hotel_provider_fee.pet_hotel_provider_id', 'pet_hotel_provider.id')
        ->select('pet_hotel_provider.*', 'pet_hotel_provider_fee.id', 'pet_hotel_provider_fee.pet_hotel_provider_id','pet_hotel_provider_fee.pet_type', 'pet_hotel_provider_fee.pet_size', 
        'pet_hotel_provider_fee.slot_available', 'pet_hotel_provider_fee.price_per_day')
        ->get();

        foreach($pet_hotel_provider as $item){
            $data_pet_hotel_provider_fee = null;
            foreach($feejoin as $data){
                if($item->id == $data->pet_hotel_provider_id){
                    $data_pet_hotel_provider_fee[] = [
                        "id" => $data->id,
                        "pet_hotel_provider_id" => $data->pet_hotel_provider_id,
                        "pet_type" => $data->pet_type,
                        "pet_size" => $data->pet_size,
                        "slot_available" => $data->slot_available,
                        "price_per_day" => $data->price_per_day
                    ];
                }
            }
           
            $joinbaru[] = [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'merchant_id' => $item->merchant_id,
                'name' => $item->name,
                'address' => $item->address,
                'phone' => $item->phone,
                'photo' => $item->photo,
                'description' => $item->description,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'data_pet_hotel_provider_fee' => $data_pet_hotel_provider_fee
            ];
        }

        $data = [
            'message' => 'Success',
            'data' => $joinbaru
        ];

        return response()->json($data, 200);
    }

}
