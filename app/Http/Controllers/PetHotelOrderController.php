<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\PetHotelProvider;
use App\Models\Merchant;
use Yajra\Datatables\Datatables;
use App\Models\PetHotelOrder;
use App\Models\PetHotelProviderAmminities;
use App\Models\PetHotelProviderAmminitiesExtra;
use App\Models\PetHotelProviderFee;
use App\Models\PetHotelProviderBookingSlots;

class PetHotelOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('role', 'User')->get();
        $petHotelProvider = PetHotelProvider::all();
        return view('Admin.Pet-Hotel-Order.index', compact('user', 'petHotelProvider'));
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

    public function get_pet_hotel_order(Request $request)
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
        ->where('pet_hotel_order.user_id', Auth::user()->id) //ini buat get semua ordernya
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
        'pet_profile.pet_description', 
        'pet_profile.pet_birthdate', 
        'pet_profile.pet_status', 
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'payments_option.payments_type',
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
        'pet_hotel_provider_amminities.basking',
        'pet_hotel_provider_amminities.cleaning',
        'pet_hotel_provider_amminities.bedding',
        'pet_hotel_provider_amminities.grooming',
        'pet_hotel_provider_amminities_extra.extra_amminities_name',
        'pet_hotel_provider_amminities_extra.extra_amminities_price_per_day',);

        // dd($pethotelorder);
        // foreach ($pethotelorder as $key => $value) {
        //    dd($value);
        // }
        $datatables = Datatables::of($pethotelorderjoin);

        if ($request->get('search')['value']) {
            $datatables->filter(function ($query) {
                    $keyword = request()->get('search')['value'];
                    $query->where('name', 'like', "%" . $keyword . "%");

        });}

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('pet_hotel_order.updated_at', $order);
        });
        return $datatables->addIndexColumn()
        ->escapeColumns([])
        ->addColumn('hotel_provider_desc','Admin.Pet-Hotel-Order.hotel-desc')
        ->addColumn('pet_desc','Admin.Pet-Hotel-Order.pet-desc')
        ->addColumn('fee_desc','Admin.Pet-Hotel-Order.fee-desc')
        ->addColumn('aminities_desc','Admin.Pet-Hotel-Order.aminities-desc')
        ->addColumn('aminities_extra_desc','Admin.Pet-Hotel-Order.aminities-extra-desc')
        ->toJson();
    }
}
