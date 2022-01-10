<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentItem;
use App\Models\User;
use App\Models\Merchant;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class RentItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('role', 'User')->get();
        return view('Admin.Rent-Item.index',compact('user'));
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

    public function get_rent_item(Request $request)
    {
        $rentItem = RentItem::leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'rent_item.user_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'rent_item.pet_id');
        })
        ->leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_profile.pet_group_id');
        })
        ->leftJoin('merchant', function ($join) {
            $join->on('merchant.id', '=', 'rent_item.merchant_id');
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
        'users.username', 'pet_grouping.pet_group_name', 'rent_item.*', 'merchant.merchant_name');

        if ($request->input('username') != null) {
            $rentItem = $rentItem->where('rent_item.user_id', $request->username);
        }

        $datatables = Datatables::of($rentItem);

        if ($request->get('search')['value']) {
            $datatables->filter(function ($query) {
                    $keyword = request()->get('search')['value'];
                    $query->where('pet_profile.pet_name', 'like', "%" . $keyword . "%");

        });}

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('rent_item.updated_at', $order);
        });

        return $datatables->addIndexColumn()
        ->escapeColumns([])
        ->addColumn('picture','Admin.Rent-Item.picture')
        ->addColumn('pet_detail','Admin.Rent-Item.detail-pet')
        ->toJson();
    }
}
