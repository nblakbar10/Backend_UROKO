<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuctionOrder;
use App\Models\User;
use App\Models\Merchant;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class AuctionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('role', 'User')->get();
        return view('Admin.Auction-Order.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function get_auction_order(Request $request)
    {
        $auctionOrder = AuctionOrder::leftJoin('users', function ($join) {
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
        'pet_grouping.pet_group_name', 
        'auction_order.*', 
        'merchant.merchant_name',
        'auction_item.auction_bid_start',
        'auction_item.qty',
        'auction_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee'
        );

        if ($request->input('username') != null) {
            // dd($request->username);
            $auctionOrder = $auctionOrder->where('auction_order.user_id', $request->username);
        }
        if ($request->input('status') != null) {
            $auctionOrder = $auctionOrder->where('auction_order.auction_order_status', $request->status);
        }

        $datatables = Datatables::of($auctionOrder);

        if ($request->get('search')['value']) {
            $datatables->filter(function ($query) {
                    $keyword = request()->get('search')['value'];
                    $query->where('pet_profile.pet_name', 'like', "%" . $keyword . "%");

        });}

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('auction_order.updated_at', $order);
        });

        return $datatables->addIndexColumn()
        ->escapeColumns([])
        ->addColumn('picture','Admin.Auction-Order.picture')
        ->addColumn('pet_detail','Admin.Auction-Order.detail-pet')
        ->toJson();
    }
}
