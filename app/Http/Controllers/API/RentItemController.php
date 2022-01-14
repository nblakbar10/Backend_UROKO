<?php

namespace App\Http\Controllers\API;
use App\Models\RentItem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use App\Models\User;
use App\Models\PetProfile;
use App\Models\Merchant;
use Illuminate\Support\Facades\Validator;

class RentItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rentitem_index()
    {
        $rentitem = RentItem::where('user_id', Auth::user()->id)->get();

        if (count($rentitem)==0) {
            $data = [
                'message' => 'Anda tidak memiliki rent Item'
            ];

            return response()->json($data, 200);
        }

        $array = [];
        foreach ($rentitem as $key => $value) {
            array_push($array, $value);
        }

        $rentitemjoin = Rentitem::leftjoin('users','users.id', 'rent_item.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'rent_item.pet_id')
        ->leftjoin('merchant','merchant.id', 'rent_item.merchant_id')
        ->select('rent_item.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('rent_item.user_id', Auth::user()->id) //ini buat get semua itemnya
        ->get();
        // dd($rentitemjoin);

        $data = [
            'message' => 'Success',
            'data' => $rentitemjoin
        ];     

        return response()->json($data, 200);
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
    public function rentitem_post(Request $request, $id)
    {
        $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        if (!$merchant) {
            $merchant = "Belum ada Merchant! silahkan bikin merchant terlebih dahulu";
            $data = [
                'message' => 'failed',
                'data' => $merchant
            ];
            return response()->json($data, 404);
        }

        $pet = PetProfile::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if ($pet == NULL) {
            $data = [
                'message' => 'Pet user tidak ada'
            ];

            return response()->json($data, 200);
        }

        $validator = Validator::make($request->all(), [
            //'pet_id' => 'required',
            'qty' => 'required',
            'description' => 'required',
            //'merchant_id' => 'required',
            'rent_item_price' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $rentitem = RentItem::create([
            'user_id' => Auth::user()->id,
            'pet_id' => $id,
            'qty' => $request->qty,
            'description' => $request->description,
            // 'merchant_id' => $merchant->id,
            'merchant_id' => $request->merchant_id,
            'rent_item_price' => $request->rent_item_price,

        ]);

        $rentitemjoin = Rentitem::leftjoin('users','users.id', 'rent_item.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'rent_item.pet_id')
        ->leftjoin('merchant','merchant.id', 'rent_item.merchant_id')
        ->select('rent_item.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('rent_item.id',$rentitem->id)
        ->get();
        // dd($rentitemjoin);

        $data = [
            'message' => 'Success',
            'data' => $rentitemjoin
        ];     

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function rentitem_edit(Request $request, $id)
    {

        $rentitem = RentItem::find($id);
        $rentitem->update($request->all());

        $rentitemjoin = Rentitem::leftjoin('users','users.id', 'rent_item.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'rent_item.pet_id')
        ->leftjoin('merchant','merchant.id', 'rent_item.merchant_id')
        ->select('rent_item.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('rent_item.id',$rentitem->id)
        ->get();

        return response()->json([
            'status' => 200,
            "message" => "edit rentitem sukses",
            "data" => $rentitemjoin
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function rentitem_delete($id)
    {
        $rentitem = RentItem::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $rentitem->delete();

        
        $allrentitem = RentItem::where('user_id', Auth::user()->id)->get();

        $rentitemjoin = Rentitem::leftjoin('users','users.id', 'rent_item.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'rent_item.pet_id')
        ->leftjoin('merchant','merchant.id', 'rent_item.merchant_id')
        ->select('rent_item.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('rent_item.user_id', Auth::user()->id) //ini buat get semua itemnya
        ->get();
        // dd($rentitemjoin);

        $data = [
            'message' => 'Success',
            'data' => $rentitemjoin
        ];
        return response()->json($data, 200);
    }
}
