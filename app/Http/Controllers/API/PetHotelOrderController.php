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

        //
        $input = $request->all();


        // foreach ($request->a as $key => $value) {
        //     $arr[] = [
        //         'a' => $value,
        //         'b' => $input['b'][$key],
        //         'c' => $input['c'][$key],
        //         'd' => $input['d'][$key],
        //     ];
        // }

        if (count($request->pet_profile_id) > 1) {
            foreach ($request->pet_profile_id as $key => $value) {
                $begin = new DateTime($input['check_in_date'][$key]);
                $end = new DateTime($input['check_out_date'][$key]);

                $interval = new DateInterval('P1D');
                $daterange = new DatePeriod($begin, $interval ,$end);
                $countdate = 0;
                foreach($daterange as $data)
                {
                    $date_duration[] = $data; 
                };
                
                $pethotelprovider_fee = PetHotelProviderFee::find($input['pet_hotel_provider_fee_id'][$key]);
                $totalorder = $pethotelprovider_fee->adoption_item_price + 4500;           //4500 ini biaya admin
                $slotRemain = $pethotelprovider_fee->slot_available - 1;

                $pethotelorder = PetHotelOrder::create([
                    'user_id' => Auth::user()->id,
                    //username, phone number, address
                    'pet_hotel_provider_id' => $id,
                    //name, photo
                    'pet_profile_id' => $input['pet_profile_id'][$key],
                    //pet_name, pet_picture, pet_gender, pet_age, pet_species, pet_weight, pet_size
                    'cage' => $input['cage'][$key],
                    'pet_caring_note' => $input['pet_caring_note'][$key],
                    'check_in_date' => $input['check_in_date'][$key],
                    'check_out_date' => $input['check_out_date'][$key],
                    'pet_hotel_provider_fee_id' => $input['pet_hotel_provider_fee_id'][$key],
                    'pet_hotel_provider_booking_slots_id' => $input['pet_hotel_provider_booking_slots_id'][$key],
                    'pet_hotel_provider_amminities_id' => $input['pet_hotel_provider_amminities_id'][$key],
                    'pet_hotel_provider_amminities_extra_id' => $input['pet_hotel_provider_amminities_extra_id'][$key],
                    'total_days' => count($date_duration). 'days',
                    'pethotel_order_status' => "Waiting for Confirmation",
                    'pethotel_total_price' => $totalorder,
                    'shipping_id' =>$input['shipping_id'][$key],
                    'payments_option_id' => $input['payments_option_id'][$key],
                ]);

                $pethotelorderID[] =+ $pethotelorder->id;

                $pethotelprovider_fee->update([
                    'slot_available' => $slotRemain
                ]);

                $savetoproviderbookingslots = PetHotelProviderBookingSlots::create([
                    'pet_hotel_provider_id' => $id,
                    'user_id' => Auth::user()->id,
                    'sitting_slots_booked' => $pethotelprovider_fee->pet_type,
                    'pet_profile_id' => $input['pet_profile_id'][$key],
                    'cage' => $input['cage'][$key],
                    'pet_caring_note' => $input['pet_caring_note'][$key],
                    'check_in_date' => $input['check_in_date'][$key],
                    'check_out_date' => $input['check_out_date'][$key],
                    'total_days' => count($date_duration). 'days',

                ]);
               
            }
        } else {
            $begin = new DateTime($request->check_in_date);
            $end = new DateTime($request->check_out_date);

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);
            $countdate = 0;
            foreach($daterange as $data)
            {
                $date_duration[] = $data; 
            };
            
            $pethotelprovider_fee = PetHotelProviderFee::find($request->pet_hotel_provider_fee_id);
            $totalorder = $pethotelprovider_fee->adoption_item_price + 4500;           //4500 ini biaya admin
            $slotRemain = $pethotelprovider_fee->slot_available - 1;

            $pethotelorder = PetHotelOrder::create([
                'user_id' => Auth::user()->id,
                //username, phone number, address
                'pet_hotel_provider_id' => $id,
                //name, photo
                'pet_profile_id' => $request->pet_profile_id,
                //pet_name, pet_picture, pet_gender, pet_age, pet_species, pet_weight, pet_size
                'cage' => $request->cage,
                'pet_caring_note' => $request->pet_caring_note,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'pet_hotel_provider_fee_id' => $request->pet_hotel_provider_fee_id,
                'pet_hotel_provider_booking_slots_id' => $request->pet_hotel_provider_booking_slots_id,
                'pet_hotel_provider_amminities_id' => $request->pet_hotel_provider_amminities_id,
                'pet_hotel_provider_amminities_extra_id' => $request->pet_hotel_provider_amminities_extra_id,
                'total_days' => count($date_duration). 'days',
                'pethotel_order_status' => "Waiting for Confirmation",
                'pethotel_total_price' => $totalorder,
                'shipping_id' =>$request->shipping_id,
                'payments_option_id' => $request->payments_option_id,
            ]);

            $pethotelorderID[] =+ $pethotelorder->id;

            $pethotelprovider_fee->update([
                'slot_available' => $slotRemain
            ]);

            $savetoproviderbookingslots = PetHotelProviderBookingSlots::create([
                'pet_hotel_provider_id' => $id,
                'user_id' => Auth::user()->id,
                'sitting_slots_booked' => $pethotelprovider_fee->pet_type,
                'pet_profile_id' => $request->pet_profile_id,
                'cage' => $request->cage,
                'pet_caring_note' => $request->pet_caring_note,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'total_days' => count($date_duration). 'days',

            ]);
        }
        
        //
        

        // $savetoproviderbookingslots = PetHotelProviderBookingSlots::update([
        // ]);

        foreach ($pethotelorderID as $key => $value) {
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
            ->where('pet_hotel_order.id',$value)
            ->select('pet_hotel_order.*',
            'users.username', 
            'users.phone_number', 
            'users.address', 
            'pet_profile.pet_picture', 
            'pet_profile.pet_name',
            'pet_profile.pet_age', 
            'shipping.shipping_type',
            'shipping.shipping_fee',
            'payments_option.payments_type',
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
            'pet_hotel_provider_booking_slots .status',
            'pet_hotel_provider_amminities.food',
            'pet_hotel_provider_amminities.basking',
            'pet_hotel_provider_amminities.cleaning',
            'pet_hotel_provider_amminities.bedding',
            'pet_hotel_provider_amminities.grooming',
            'pet_hotel_provider_amminities_extra.extra_amminities_name',
            'pet_hotel_provider_amminities_extra.extra_amminities_price_per_day',)
            ->get();

            $pethotelorderFIX[] =+ $pethotelorderjoin;
        }
        
        // dd($pethotelorderjoin);

        $data = [
            'message' => 'Success',
            'data' => $pethotelorderFIX
        ];     
        return response()->json($data, 200);
    }


    public function pethotel_order_getall(Request $request) //ambil semua transaksi pethotel order yg dilakukan oleh user
    {

        $pethotelorder = PetHotelOrder::where('user_id', Auth::user()->id)->get();
        if (!$pethotelorder) {
            $data = [
                'message' => 'adoption order not found'
            ];
            return response()->json($data, 404);
        }

        $pethotelorderjoin = PetHotelOrder::leftjoin('users','users.id', 'adoption_order.user_id')
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
        ->where('adoption_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->select('pet_hotel_order.*',
        'users.username', 
        'users.phone_number', 
        'users.address', 
        'payments_option.payments_type',
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
        'pet_hotel_provider_booking_slots .status',
        'shipping.shipping_type',
        'shipping.shipping_fee',
        'pet_hotel_provider_amminities.food',
        'pet_hotel_provider_amminities.basking',
        'pet_hotel_provider_amminities.cleaning',
        'pet_hotel_provider_amminities.bedding',
        'pet_hotel_provider_amminities.grooming',
        'pet_hotel_provider_amminities_extra.extra_amminities_name',
        'pet_hotel_provider_amminities_extra.extra_amminities_price_per_day',)
        ->get();

        return response()->json($pethotelorderjoin, 200);
        
    }

    public function pethotel_order_cancel(Request $request, $id) //id si pethotel_order
    {
        $pethotelorder = PetHotelOrder::findOrFail($id);
        if (!$pethotelorder) {
            $data = [
                'message' => 'adoption order not found'
            ];
            return response()->json($data, 404);
        }

        $pethotelorder->update(['pethotel_order_status' => 'CANCELLED']);

        $pethotelorder = PetHotelOrder::leftjoin('users','users.id', 'pet_hotel_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'pet_hotel_order.pet_profile_id')
        ->leftJoin('shipping', function ($join) {
            $join->on('shipping.id', '=', 'pet_hotel_order.shipping_id');
        })
        ->leftjoin('pet_hotel_provider','pet_hotel_provider.id', 'pet_hotel_order.pet_hotel_provider_id')
        ->leftjoin('pet_hotel_provider_fee','pet_hotel_provider_fee.id', 'pet_hotel_order.pet_hotel_provider_fee_id')
        ->leftjoin('pet_hotel_provider_booking_slots','pet_hotel_provider_booking_slots.id', 'pet_hotel_order.pet_hotel_provider_booking_slots_id')
        ->leftjoin('pet_hotel_provider_amminities','pet_hotel_provider_amminities.id', 'pet_hotel_order.pet_hotel_provider_amminities_id')
        ->leftjoin('pet_hotel_provider_amminities_extra','pet_hotel_provider_amminities_extra.id', 'pet_hotel_order.pet_hotel_provider_amminities_extra_id')
        ->where('pet_hotel_order.id', $id)
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
        'pet_hotel_provider_booking_slots .status',
        'pet_hotel_provider_amminities.food',
        'shipping.shipping_type',
        'shipping.shipping_fee',    
        'pet_hotel_provider_amminities.basking',
        'pet_hotel_provider_amminities.cleaning',
        'pet_hotel_provider_amminities.bedding',
        'pet_hotel_provider_amminities.grooming',
        'pet_hotel_provider_amminities_extra.extra_amminities_name',
        'pet_hotel_provider_amminities_extra.extra_amminities_price_per_day',)
        // ->where('adoption_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json([
            'status' => 200,
            'message' =>'Cancel adoption order success',
            'data' => $pethotelorder
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
