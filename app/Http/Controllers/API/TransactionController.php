<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\Merchant;
use App\Models\PetProfile;
use App\Models\AdoptionOrder;
use App\Models\AuctionOrder;
use App\Models\RentOrder;
use App\Models\PetActivity;
use App\Models\PetHotelOrder;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function get_all_transaction()
    {
        $dataAdoptionOrder = AdoptionOrder::leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'adoption_order.user_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'adoption_order.pet_id');
        })
        ->leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_profile.pet_group_id');
        })
        ->leftJoin('merchant', function ($join) {
            $join->on('merchant.id', '=', 'adoption_order.merchant_id');
        })
        ->leftJoin('adoption_item', function ($join) {
            $join->on('adoption_item.id', '=', 'adoption_order.adoption_item_id');
        })
        ->leftJoin('shipping', function ($join) {
            $join->on('shipping.id', '=', 'adoption_order.shipping_id');
        })
        ->leftJoin('payments_option', function ($join) {
            $join->on('payments_option.id', '=', 'adoption_order.payments_option_id');
        })
        ->where('users.id', Auth::user()->id)
        ->select('pet_profile.pet_name',
        'pet_profile.pet_species',
        'pet_profile.pet_breed',
        'pet_profile.pet_morph',
        'pet_profile.pet_birthdate',
        'pet_profile.pet_age',
        'pet_profile.pet_description',
        'pet_profile.pet_picture',
        'pet_profile.pet_picture2',
        'pet_profile.pet_status',
        'users.username',
        'users.picture',
        'users.picture2',
        'pet_grouping.pet_group_name', 
        'adoption_order.*', 
        'merchant.merchant_name',
        'adoption_item.adoption_item_price',
        'adoption_item.qty',
        'adoption_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'payments_option.payments_type'
        )->get();

        $dataAuctionOrder = AuctionOrder::leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'auction_order.user_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'auction_order.pet_id');
        })
        ->leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_profile.pet_group_id');
        })
        ->leftJoin('merchant', function ($join) {
            $join->on('merchant.id', '=', 'auction_order.merchant_id');
        })
        ->leftJoin('auction_item', function ($join) {
            $join->on('auction_item.id', '=', 'auction_order.auction_item_id');
        })
        ->leftJoin('shipping', function ($join) {
            $join->on('shipping.id', '=', 'auction_order.shipping_id');
        })
        ->leftJoin('payments_option', function ($join) {
            $join->on('payments_option.id', '=', 'auction.payments_option_id');
        })
        ->where('users.id', Auth::user()->id)
        ->select('pet_profile.pet_name',
        'pet_profile.pet_species',
        'pet_profile.pet_breed',
        'pet_profile.pet_morph',
        'pet_profile.pet_birthdate',
        'pet_profile.pet_age',
        'pet_profile.pet_description',
        'pet_profile.pet_picture',
        'pet_profile.pet_picture2',
        'pet_profile.pet_status',
        'users.username',
        'users.picture',
        'users.picture2',
        'pet_grouping.pet_group_name', 
        'auction_order.*', 
        'merchant.merchant_name',
        'auction_item.auction_bid_start',
        'auction_item.qty',
        'auction_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'payments_option.payments_type'
        )->get();
        
        $dataRentOrder = RentOrder::leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'rent_order.user_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'rent_order.pet_id');
        })
        ->leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_profile.pet_group_id');
        })
        ->leftJoin('merchant', function ($join) {
            $join->on('merchant.id', '=', 'rent_order.merchant_id');
        })
        ->leftJoin('rent_item', function ($join) {
            $join->on('rent_item.id', '=', 'rent_order.rent_item_id');
        })
        ->leftJoin('shipping', function ($join) {
            $join->on('shipping.id', '=', 'rent_order.shipping_id');
        })
        ->leftJoin('payments_option', function ($join) {
            $join->on('payments_option.id', '=', 'rent_order.payments_option_id');
        })
        ->where('users.id', Auth::user()->id)
        ->select('pet_profile.pet_name',
        'pet_profile.pet_species',
        'pet_profile.pet_breed',
        'pet_profile.pet_morph',
        'pet_profile.pet_birthdate',
        'pet_profile.pet_age',
        'pet_profile.pet_description',
        'pet_profile.pet_picture',
        'pet_profile.pet_picture2',
        'pet_profile.pet_status',
        'users.username',
        'users.picture',
        'users.picture2',
        'pet_grouping.pet_group_name', 
        'rent_order.*', 
        'merchant.merchant_name',
        'rent_item.rent_item_price',
        'rent_item.qty',
        'rent_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'payments_option.payments_type'
        )->get();

        $pethotelorderjoin = PetHotelOrder::leftjoin('users','users.id', 'pet_hotel_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'pet_hotel_order.pet_profile_id')
        ->leftJoin('shipping', function ($join) {
            $join->on('shipping.id', '=', 'pet_hotel_order.shipping_id');
        })
        ->leftJoin('payments_option', function ($join) {
            $join->on('payments_option.id', '=', 'pet_hotel_order.payments_option_id');
        })
        ->leftjoin('pet_hotel_provider','pet_hotel_provider.id', 'pet_hotel_order.pet_hotel_provider_id')
        ->leftjoin('pet_hotel_provider_fee','pet_hotel_provider_fee.id', 'pet_hotel_order.pet_hotel_provider_fee_id')
        ->leftjoin('pet_hotel_provider_booking_slots','pet_hotel_provider_booking_slots.id', 'pet_hotel_order.pet_hotel_provider_booking_slots_id')
        ->leftjoin('pet_hotel_provider_amminities','pet_hotel_provider_amminities.id', 'pet_hotel_order.pet_hotel_provider_amminities_id')
        ->leftjoin('pet_hotel_provider_amminities_extra','pet_hotel_provider_amminities_extra.id', 'pet_hotel_order.pet_hotel_provider_amminities_extra_id')
        // ->leftjoin('merchant','merchant.id', 'adoption_order.merchant_id')
        ->where('users.id',Auth::user()->id)
        ->select('pet_hotel_order.*',
        'users.username', 
        'users.phone_number', 
        'users.address', 
        'pet_profile.pet_picture', 
        'pet_profile.pet_name',
        'pet_profile.pet_age', 
        'pet_profile.pet_species', 
        'pet_profile.pet_breed', 
        'pet_profile.pet_gender', 
        'pet_profile.pet_size', 
        'pet_profile.pet_weight',
        'pet_hotel_provider.merchant_id',
        'pet_hotel_provider.name',
        'pet_hotel_provider.address',
        'pet_hotel_provider.phone',
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'pet_hotel_provider.photo',
        'pet_hotel_provider.description',
        'pet_hotel_provider_fee.pet_type',
        'pet_hotel_provider_fee.pet_size',
        'payments_option.payments_type',
        'pet_hotel_provider_fee.slot_available',
        'pet_hotel_provider_fee.price_per_day',
        'pet_hotel_provider_booking_slots.status',
        'pet_hotel_provider_amminities.food',
        'pet_hotel_provider_amminities.basking',
        'pet_hotel_provider_amminities.cleaning',
        'pet_hotel_provider_amminities.bedding',
        'pet_hotel_provider_amminities.grooming',
        'pet_hotel_provider_amminities_extra.extra_amminities_name',
        'pet_hotel_provider_amminities_extra.extra_amminities_price_per_day',)
        ->get();

        $adoption = [];
        $auction = [];
        $rent = [];
        $hotel = [];
        
        $allTransaction = $dataAdoptionOrder->concat($dataAuctionOrder)->concat($dataRentOrder)->concat($pethotelorderjoin);
        foreach ($allTransaction as $key => $value) {
            if ($value->adoption_item_id) {
                $value['order_type'] = 'Adoption Order';
                $adoption[] = $value;
            } elseif ($value->auction_item_id) {
                $value['order_type'] = 'Auction Order';
                $auction[] = $value;
            } elseif ($value->rent_item_id) {
                $value['order_type'] = 'Rent Order';
                $rent[] = $value;
            } elseif ($value->pet_hotel_provider_id) {
                $value['order_type'] = 'Pet Hotel Order';
                $hotel[] = $value;
            }
        }

        $data = [
            'Adoption_Order' => $adoption,
            'Auction_Order' =>  $auction,
            'Rent_order' => $rent,
            'Pet_Hotel_order' => $hotel,
        ];

        return response()->json([
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    public function get_pet_hotel_order($hotel_id)
    {
        $pethotelorderjoin = PetHotelOrder::leftjoin('users','users.id', 'pet_hotel_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'pet_hotel_order.pet_profile_id')
        ->leftjoin('pet_hotel_provider','pet_hotel_provider.id', 'pet_hotel_order.pet_hotel_provider_id')
        ->leftJoin('shipping', function ($join) {
            $join->on('shipping.id', '=', 'pet_hotel_order.shipping_id');
        })
        ->leftJoin('payments_option', function ($join) {
            $join->on('payments_option.id', '=', 'pet_hotel_order.payments_option_id');
        })
        ->leftjoin('pet_hotel_provider_fee','pet_hotel_provider_fee.id', 'pet_hotel_order.pet_hotel_provider_fee_id')
        ->leftjoin('pet_hotel_provider_booking_slots','pet_hotel_provider_booking_slots.id', 'pet_hotel_order.pet_hotel_provider_booking_slots_id')
        ->leftjoin('pet_hotel_provider_amminities','pet_hotel_provider_amminities.id', 'pet_hotel_order.pet_hotel_provider_amminities_id')
        ->leftjoin('pet_hotel_provider_amminities_extra','pet_hotel_provider_amminities_extra.id', 'pet_hotel_order.pet_hotel_provider_amminities_extra_id')
        // ->leftjoin('merchant','merchant.id', 'adoption_order.merchant_id')
        ->where('pet_hotel_provider.id',$hotel->id)
        ->select('pet_hotel_order.*',
        'users.username', 
        'users.phone_number', 
        'users.address', 
        'pet_profile.pet_picture', 
        'pet_profile.pet_name',
        'pet_profile.pet_age', 
        'pet_profile.pet_species', 
        'pet_profile.pet_breed', 
        'pet_profile.pet_gender', 
        'pet_profile.pet_size', 
        'pet_profile.pet_weight',
        'pet_hotel_provider.merchant_id',
        'pet_hotel_provider.name',
        'pet_hotel_provider.address',
        'pet_hotel_provider.phone',
        'pet_hotel_provider.photo',
        'pet_hotel_provider.description',
        'pet_hotel_provider_fee.pet_type',
        'pet_hotel_provider_fee.pet_size',
        'pet_hotel_provider_fee.slot_available',
        'pet_hotel_provider_fee.price_per_day',
        'pet_hotel_provider_booking_slots.status',
        'pet_hotel_provider_amminities.food',
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'payments_option.payments_type',
        'pet_hotel_provider_amminities.basking',
        'pet_hotel_provider_amminities.cleaning',
        'pet_hotel_provider_amminities.bedding',
        'pet_hotel_provider_amminities.grooming',
        'pet_hotel_provider_amminities_extra.extra_amminities_name',
        'pet_hotel_provider_amminities_extra.extra_amminities_price_per_day',)
        ->get();

        $hotel = [];
        
        foreach ($pethotelorderjoin as $key => $value) {
            if ($value->pet_hotel_provider_id) {
                $value['order_type'] = 'Pet Hotel Order';
                $hotel[] = $value;
            }
        }

        $data = [
            'Pet_Hotel_order' => $hotel,
        ];

        return response()->json([
            'message' => 'Success',
            'data' => $data
        ], 200);
    }
    public function get_merchant_order($merchant_id)
    {
        $dataAdoptionOrder = AdoptionOrder::leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'adoption_order.user_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'adoption_order.pet_id');
        })
        ->leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_profile.pet_group_id');
        })
        ->leftJoin('merchant', function ($join) {
            $join->on('merchant.id', '=', 'adoption_order.merchant_id');
        })
        ->leftJoin('adoption_item', function ($join) {
            $join->on('adoption_item.id', '=', 'adoption_order.adoption_item_id');
        })
        ->leftJoin('shipping', function ($join) {
            $join->on('shipping.id', '=', 'adoption_order.shipping_id');
        })
        ->leftJoin('payments_option', function ($join) {
            $join->on('payments_option.id', '=', 'adoption_order.payments_option_id');
        })
        ->where('merchant.id', $merchant_id)
        ->select('pet_profile.pet_name',
        'pet_profile.pet_species',
        'pet_profile.pet_breed',
        'pet_profile.pet_morph',
        'pet_profile.pet_birthdate',
        'pet_profile.pet_age',
        'pet_profile.pet_description',
        'pet_profile.pet_picture',
        'pet_profile.pet_picture2',
        'pet_profile.pet_status',
        'users.username',
        'users.picture',
        'users.picture2',
        'pet_grouping.pet_group_name', 
        'adoption_order.*', 
        'merchant.merchant_name',
        'adoption_item.adoption_item_price',
        'adoption_item.qty',
        'adoption_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'payments_option.payments_type'
        )->get();
        $dataAuctionOrder = AuctionOrder::leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'auction_order.user_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'auction_order.pet_id');
        })
        ->leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_profile.pet_group_id');
        })
        ->leftJoin('merchant', function ($join) {
            $join->on('merchant.id', '=', 'auction_order.merchant_id');
        })
        ->leftJoin('auction_item', function ($join) {
            $join->on('auction_item.id', '=', 'auction_order.auction_item_id');
        })
        ->leftJoin('shipping', function ($join) {
            $join->on('shipping.id', '=', 'auction_order.shipping_id');
        })
        ->leftJoin('payments_option', function ($join) {
            $join->on('payments_option.id', '=', 'auction.payments_option_id');
        })
        ->where('users.id', Auth::user()->id)
        ->select('pet_profile.pet_name',
        'pet_profile.pet_species',
        'pet_profile.pet_breed',
        'pet_profile.pet_morph',
        'pet_profile.pet_birthdate',
        'pet_profile.pet_age',
        'pet_profile.pet_description',
        'pet_profile.pet_picture',
        'pet_profile.pet_picture2',
        'pet_profile.pet_status',
        'users.username',
        'users.picture',
        'users.picture2',
        'pet_grouping.pet_group_name', 
        'auction_order.*', 
        'merchant.merchant_name',
        'auction_item.auction_bid_start',
        'auction_item.qty',
        'auction_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'payments_option.payments_type'
        )->get();
        
        $dataRentOrder = RentOrder::leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'rent_order.user_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'rent_order.pet_id');
        })
        ->leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_profile.pet_group_id');
        })
        ->leftJoin('merchant', function ($join) {
            $join->on('merchant.id', '=', 'rent_order.merchant_id');
        })
        ->leftJoin('rent_item', function ($join) {
            $join->on('rent_item.id', '=', 'rent_order.rent_item_id');
        })
        ->leftJoin('shipping', function ($join) {
            $join->on('shipping.id', '=', 'rent_order.shipping_id');
        })
        ->leftJoin('payments_option', function ($join) {
            $join->on('payments_option.id', '=', 'rent_order.payments_option_id');
        })
        ->where('users.id', Auth::user()->id)
        ->select('pet_profile.pet_name',
        'pet_profile.pet_species',
        'pet_profile.pet_breed',
        'pet_profile.pet_morph',
        'pet_profile.pet_birthdate',
        'pet_profile.pet_age',
        'pet_profile.pet_description',
        'pet_profile.pet_picture',
        'pet_profile.pet_picture2',
        'pet_profile.pet_status',
        'users.username',
        'users.picture',
        'users.picture2',
        'pet_grouping.pet_group_name', 
        'rent_order.*', 
        'merchant.merchant_name',
        'rent_item.rent_item_price',
        'rent_item.qty',
        'rent_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'payments_option.payments_type'
        )->get();
        $adoption = [];
        $auction = [];
        $rent = [];

        $allTransaction = $dataAdoptionOrder->concat($dataAuctionOrder)->concat($dataRentOrder);
        foreach ($allTransaction as $key => $value) {
            if ($value->adoption_item_id) {
                $value['order_type'] = 'Adoption Order';
                $adoption[] = $value;
            } elseif ($value->auction_item_id) {
                $value['order_type'] = 'Auction Order';
                $auction[] = $value;
            } elseif ($value->rent_item_id) {
                $value['order_type'] = 'Rent Order';
                $rent[] = $value;
            }
        }

        $data = [
            'Adoption_Order' => $adoption,
            'Auction_Order' =>  $auction,
            'Rent_order' => $rent,
        ];

        return response()->json([
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    public function confirm_order($order_id,$order_type)
    {
        if ($order_type == 'Adoption Order') {
            $adoption = AdoptionOrder::find($order_id);
            $adoption->update([
                'adoption_order_status' => 'Approved'
            ]);

            $data = $adoption;
        } elseif ($order_type == 'Auction Order') {
            $auction = AuctionOrder::find($order_id);
            $auction->update([
                'auction_order_status' => 'Approved'
            ]);
            $data = $auction;
        } elseif ($order_type == 'Rent Order') {
            $rent = RentOrder::find($order_id);
            $rent->update([
                'rent_order_status' => 'Approved'
            ]);
            $data = $rent;
        } 

        return response()->json($data, 200);
    }

    public function confirm_hotel_order($order_id)
    {
        $hotel = PetHotelOrder::find($order_id);
        $hotel->update([
            'pethotel_order_status' => 'Approved'
        ]);
        $data = $hotel;

        return response()->json($data, 200);
    }

    public function reject_order($order_id,$order_type)
    {
        if ($order_type == 'Adoption Order') {
            $adoption = AdoptionOrder::find($order_id);
            $adoption->update([
                'adoption_order_status' => 'Rejected'
            ]);
            
            $data = $adoption;
        } elseif ($order_type == 'Auction Order') {
            $adoption = AuctionOrder::find($order_id);
            $adoption->update([
                'auction_order_status' => 'Rejected'
            ]);
            
            $data = $auction;
        } elseif ($order_type == 'Rent Order') {
            $adoption = RentOrder::find($order_id);
            $adoption->update([
                'rent_order_status' => 'Rejected'
            ]);
            
            $data = $adoption;
        } 

        return response()->json($data, 200);
    }

    public function reject_hotel_order($order_id)
    {
        $hotel = PetHotelOrder::find($order_id);
        $hotel->update([
            'pethotel_order_status' => 'Rejected'
        ]);
        $data = $hotel;

        return response()->json($data, 200);
    }
}
