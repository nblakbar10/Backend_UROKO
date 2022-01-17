<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetActivity;
use App\Models\PetGroup;
use App\Models\PetProfile;
use Auth;
use App\Models\PetHotelOrder;
use App\Models\PetHotelProvider;
use App\Models\PetHotelProviderBookingSlots;
//use App\Models\PetHotelExtraAmminities;
use Illuminate\Support\Facades\Validator;

class PetHotelOrderController extends Controller
{
    public function pethotel_order_post(Request $request, $id) //id si pethotel provider
    {
        $provider = PetHotelProvider::findOrFail($id);
        if (!$provider) {
            $data = [
                'message' => 'pet_hotel_provider not found'
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [
            'pet_profile_id' => 'required',
            'cage' => 'required',
            'pet_caring_note' => 'required',
            'check_in_date' => 'required',
            'check_out_date' => 'required',
            'total_days' => 'required',
            'pet_hotel_amminities_selected_id' => 'required',
            'pet_hotel_provider_fee_id' => 'required',
            // 'grand_total_order' => 
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }
        ////$namamerchant = Merchant::find($id);
        $pethotel_fee = PetHotelProvider::find($id)->adoption_item_price;
        $totalorder = $adoptprice + 4500;           //4500 ini biaya admin

        $pethotelorder = PetHotelOrder::create([
            'user_id' => Auth::user()->id,
            'pet_profile_id' => $provider->pet_profile_id,
            ////'username' => Auth::user()->username,
            ////'phone_number' => Auth::user()->phone_number,
            ////'address' => Auth::user()->address,
            'adoption_item_id' => $id,
            'merchant_id' => $provider->merchant_id,    //$namamerchant->merchant_name,
            'pet_id' => $provider->pet_id,
            'shipping_id' =>$request->shipping_id,
            ////'shipping_type' => $ships->shipping_type,
            'payments_option_id' => $request->payments_option_id,
            ////'payments_option' => $payms->payment_type,
            'adoption_order_notes' =>$request->adoption_order_notes,
            'grand_total_order' => $totalorder,
            // 'pet_id' => $id,
            // 'qty' => $request->qty,
            // 'description' => $request->description,
            // 'merchant_id' => $request->merchant_id,
            'adoption_order_status' => "BELUM DIKONFIRMASI"
            // 'user_address' => $alamat->address,
            // 'adoption_item_price' => $request->adoption_item_price,
        ]);

        $adoptionorderjoin = AdoptionOrder::leftjoin('users','users.id', 'adoption_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'adoption_order.merchant_id')
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('adoption_order.id',$adoptionorder->id)
        ->get();
        // dd($adoptionorderjoin);

        $data = [
            'message' => 'Success',
            'data' => $adoptionorderjoin
        ];     
        return response()->json($data, 200);
    }

    public function pethotel_order_getdetail(Request $request, $id)
    {
        // $adoptionorder = AdoptionOrder::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $adoptionorder = AdoptionOrder::findOrFail($id);
        if (!$adoptionorder) {
            $data = [
                'message' => 'adoption order not found'
            ];
            return response()->json($data, 404);
        }

        $adoptionorderjoin = AdoptionOrder::leftjoin('users','users.id', 'adoption_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'adoption_order.merchant_id')
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('adoption_order.id', $id)
        // ->where('adoption_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($adoptionorderjoin, 200);
    }

    public function pethotel_order_getall(Request $request)
    {

        $adoptionorder = AdoptionOrder::where('user_id', Auth::user()->id)->get();
        if (!$adoptionorder) {
            $data = [
                'message' => 'adoption order not found'
            ];
            return response()->json($data, 404);
        }

        $adoptionorderjoin = AdoptionOrder::leftjoin('users','users.id', 'adoption_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'adoption_order.merchant_id')
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('adoption_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($adoptionorderjoin, 200);
        
    }

    public function pethotel_order_cancel(Request $request, $id)
    {
        $adoptionorder = AdoptionOrder::findOrFail($id);
        if (!$adoptionorder) {
            $data = [
                'message' => 'adoption order not found'
            ];
            return response()->json($data, 404);
        }

        $adoptionorder->update(['adoption_order_status' => 'CANCELLED']);

        $adoptionorderjoin = AdoptionOrder::leftjoin('users','users.id', 'adoption_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'adoption_order.merchant_id')
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('adoption_order.id', $id)
        // ->where('adoption_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json([
            'status' => 200,
            'message' =>'Cancel adoption order success',
            'data' => $adoptionorderjoin
        ]);
    }
    //bikin fungsi : pethotel_services_list_get, pethotel_services_request_post, pethotel_services_request_edit, 
    // pethotel_services_request_delete

    //dibikin logika untuk memilih dulu apakah mau menjual jasa pethotel atas nama pribadi atau merchant,
    //kalau merchant berarti ngambil id_merchant, kalau user berarti ngambil id_user


    //bikin lagi

    //function buat provider :

    //function buat client/consumer : 

    //controller : PetHotelProvider //buat provider, terus nanti ada function
    //controlelr : PetHotelOrder //buat consumer
}
