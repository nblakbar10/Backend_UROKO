<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Merchant;
use App\Models\PetProfile;
use App\Models\AdoptionOrder;
use App\Models\AuctionOrder;
use App\Models\RentOrder;
use App\Models\PetActivity;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        function convert($harga)
        {
            return strrev(implode('.', str_split(strrev(strval($harga)), 3)));
        };

        $user = User::where('role', 'User')->get()->count();
        $merchant = Merchant::all()->count();
        $transaksi = RentOrder::all()->count() + AdoptionOrder::all()->count() + AuctionOrder::all()->count();
        $pet_profile = PetProfile::all()->count();
        $nominalAdoptionOrder = convert(AdoptionOrder::all()->sum('grand_total_order'));
        $nominalAuctionOrder = convert(AuctionOrder::all()->sum('grand_total_order'));
        $nominalRentOrder = convert(RentOrder::all()->sum('grand_total_order'));
        
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
        ->select('pet_profile.pet_name',
        'pet_profile.pet_species',
        'pet_profile.pet_breed',
        'pet_profile.pet_morph',
        'pet_profile.pet_birthdate',
        'pet_profile.pet_age',
        'pet_profile.pet_description',
        'pet_profile.pet_picture',
        'pet_profile.pet_status',
        'users.username',
        'users.picture',
        'pet_grouping.pet_group_name', 
        'adoption_order.*', 
        'merchant.merchant_name',
        'adoption_item.adoption_item_price',
        'adoption_item.qty',
        'adoption_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee'
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
        ->select('pet_profile.pet_name',
        'pet_profile.pet_species',
        'pet_profile.pet_breed',
        'pet_profile.pet_morph',
        'pet_profile.pet_birthdate',
        'pet_profile.pet_age',
        'pet_profile.pet_description',
        'pet_profile.pet_picture',
        'pet_profile.pet_status',
        'users.username',
        'users.picture',
        'pet_grouping.pet_group_name', 
        'auction_order.*', 
        'merchant.merchant_name',
        'auction_item.auction_bid_start',
        'auction_item.qty',
        'auction_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee'
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
        ->select('pet_profile.pet_name',
        'pet_profile.pet_species',
        'pet_profile.pet_breed',
        'pet_profile.pet_morph',
        'pet_profile.pet_birthdate',
        'pet_profile.pet_age',
        'pet_profile.pet_description',
        'pet_profile.pet_picture',
        'pet_profile.pet_status',
        'users.username',
        'users.picture',
        'pet_grouping.pet_group_name', 
        'rent_order.*', 
        'merchant.merchant_name',
        'rent_item.rent_item_price',
        'rent_item.qty',
        'rent_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee'
        )->get();

        $smallActivity =  PetActivity::leftjoin('users', 'users.id', 'pet_activity.user_id')
        ->leftjoin('pet_profile', 'pet_profile.id', 'pet_activity.pet_id')
        ->select('pet_activity.*', 'users.username', 'users.picture', 'pet_profile.pet_name')->take(4)->get();
        $allTransaction = $dataAdoptionOrder->concat($dataAuctionOrder)->concat($dataRentOrder)->take(5);

        // foreach ($allTransaction as $key => $value) {
        //     echo($value);
        // }
        return view('index', compact(
            'user',
            'merchant',
            'pet_profile',
            'transaksi',
            'nominalAdoptionOrder',
            'nominalAuctionOrder',
            'nominalRentOrder',
            'smallActivity',
            'allTransaction'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function all_activity()
    {
        $allActivity =  PetActivity::leftjoin('users', 'users.id', 'pet_activity.user_id')
        ->leftjoin('pet_profile', 'pet_profile.id', 'pet_activity.pet_id')
        ->select('pet_activity.*', 'users.username', 'users.picture', 'pet_profile.pet_name')->paginate(7);

        return view('index-allactivity', compact(
            'allActivity'
        ));
    }
}
