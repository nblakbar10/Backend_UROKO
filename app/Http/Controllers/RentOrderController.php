<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentOrder;
use App\Models\User;
use App\Models\Merchant;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class RentOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('role', 'User')->get();
        return view('Admin.Rent-Order.index',compact('user'));
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

    public function get_rent_order(Request $request)
    {
        $rentOrder = RentOrder::leftJoin('users', function ($join) {
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
        'pet_grouping.pet_group_name', 
        'rent_order.*', 
        'merchant.merchant_name',
        'rent_item.rent_item_price',
        'rent_item.qty',
        'rent_item.description',
        'shipping.shipping_type',
        'shipping.shipping_fee'
        );

        if ($request->input('username') != null) {
            // dd($request->username);
            $rentOrder = $rentOrder->where('rent_order.user_id', $request->username);
        }
        if ($request->input('status') != null) {
            $rentOrder = $rentOrder->where('rent_order.rent_order_status', $request->status);
        }

        $datatables = Datatables::of($rentOrder);

        if ($request->get('search')['value']) {
            $datatables->filter(function ($query) {
                    $keyword = request()->get('search')['value'];
                    $query->where('pet_profile.pet_name', 'like', "%" . $keyword . "%");

        });}

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('rent_order.updated_at', $order);
        });

        return $datatables->addIndexColumn()
        ->escapeColumns([])
        ->addColumn('picture','Admin.Rent-Order.picture')
        ->addColumn('pet_detail','Admin.Rent-Order.detail-pet')
        ->toJson();
    }


    // public function rentorder_cancel(Request $request, $id)
    // {
    //     $rentorder = rentOrder::findOrFail($id);
    //     if (!$auctionorder) {
    //         $data = [
    //             'message' => 'rent order not found'
    //         ];
    //         return response()->json($data, 404);
    //     }

    //     $rentorder->update(['rent_order_status' => 'CANCELLED']);

    //     return response()->json([
    //         'status' => 200,
    //         'message' =>'Cancel rent order success',
    //         'data' => $rentorder
    //     ]);
    // }
}
