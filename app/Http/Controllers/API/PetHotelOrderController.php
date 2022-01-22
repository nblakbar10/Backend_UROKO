<?php

namespace App\Http\Controllers\API;

use DateTime, DatePeriod, DateInterval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetActivity;
use App\Models\PetGroup;
use App\Models\PetProfile;
use Auth;
use App\Models\PetHotelOrder;
use App\Models\PetHotelProvider;
use App\Models\PetHotelProviderBookingSlots;
// use App\Models\PetHotelExtraAmminities;
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
            // 'pet_profile_id' => 'required',
            'cage' => 'required', //yes or no
            'pet_caring_note' => 'required',
            'check_in_date' => 'required',
            'check_out_date' => 'required',
            // 'total_days' => 'required',
            // // 'pet_hotel_amminities_selected_id' => 'required',
            // 'pet_hotel_provider_fee_id' => 'required',
            'shipping_id' => 'required',
            'payments_option_id' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $begin = new DateTime($request->check_in_date);
        $end = new DateTime($request->check_out_date);

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        $countdate = 0;
        foreach($daterange as $data)
        {
            $date_duration[] = $data; 
        };
        
        $pethotelprovider_fee = PetHotelProviderFee::find($id)->adoption_item_price;
        $totalorder = $pethotelprovider_fee + 4500;           //4500 ini biaya admin

        $pethotelorder = PetHotelOrder::create([
            'user_id' => Auth::user()->id,
            'pet_hotel_provider_id' => $id,
            'pet_profile_id' => $request->pet_profile_id,
            'cage' => $request->cage,
            'pet_caring_note' => $request->pet_caring_note,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_days' => count($date_duration). 'days',
            'pethotel_order_status' => "Waiting for Confirmation",
            'pethotel_total_price' => $totalorder,
            'shipping_id' =>$request->shipping_id,
            'payments_option_id' => $request->payments_option_id,
        ]);

        $savetoproviderbookingslots = PetHotelProviderBookingSlots::create([
            'pet_hotel_provider_id' => $id,
            'user_id' => Auth::user()->id,
            'sitting_slots_booked' => $petprofile->pet_type,
            'pet_profile_id' => $request->pet_profile_id,
            'cage' => $request->cage,
            'pet_caring_note' => $request->pet_caring_note,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_days' => count($date_duration). 'days',

        ]);

        $savetoproviderbookingslots = PetHotelProviderBookingSlots::update([
        ]);

        $pethotelorderjoin = PetHotelOrder::leftjoin('users','users.id', 'pet_hotel_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'pet_hotel_order.pet_profile_id')
        // ->leftjoin('merchant','merchant.id', 'adoption_order.merchant_id')
        ->select('pet_hotel_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',)
        ->where('pet_hotel_order.id',$pethotelorder->id)
        ->get();
        // dd($pethotelorderjoin);

        $data = [
            'message' => 'Success',
            'data' => $pethotelorderjoin
        ];     
        return response()->json($data, 200);
    }


    public function pethotel_order_getall(Request $request) //ambil semua transaksi pethotel order yg dilakukan oleh user
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
        'merchant.merchant_name', 'merchant.merchant_image')
        ->where('adoption_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($adoptionorderjoin, 200);
        
    }

    public function pethotel_order_cancel(Request $request, $id) //id si pethotel_order
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
        'merchant.merchant_name', 'merchant.merchant_image')
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
