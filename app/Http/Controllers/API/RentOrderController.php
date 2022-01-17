<?php

namespace App\Http\Controllers\API;
use App\Models\RentOrder;

use DateTime, DatePeriod, DateInterval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use App\Models\User;
use App\Models\PetProfile;
use App\Models\Merchant;
use App\Models\RentItem;
use Illuminate\Support\Facades\Validator;

class RentOrderController extends Controller
{
    public function rentorder_post(Request $request, $id)
    {
        $rentitem = RentItem::findOrFail($id);
        if (!$rentitem) {
            $data = [
                'message' => 'rent item not found'
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            // 'qty' => 'required',
            'rent_order_notes' => 'required',
            'shipping_id' => 'required',
            'payments_option_id' => 'required',
            'rent_order_start' => 'required',
            'rent_order_return' => 'required',
            // 'grand_total_order' => 

        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        ////$namamerchant = Merchant::find($id);
        $rentprice = RentItem::find($id)->rent_item_price;

        $totalorder = $rentprice + 4500; //4500 adalah biaya admin
        ////$payms = PaymentsOption::find($id);
        ////$ships = Shipping::find($id);
        $begin = new DateTime($request->rent_order_start);
        $end = new DateTime($request->rent_order_return);

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        $countdate = 0;
        foreach($daterange as $data)
        {
            $date_duration[] = $data; 
        };
        // dd(count($array));

        //untuk mencari total hari dalam sewanya
        // // $duration = CarbonPeriod::create([
        // //     'rent_order_start' => $request->rent_order_start, 
        // //     'rent_order_return' => $request->rent_order_return
        // // ]);

        // // // Iterate over the period
        // // foreach ($duration as $date) {
        // //     echo $date->format('Y-m-d');
        // // }

        // // // Convert the period to an array of dates
        // // $dates = $duration->toArray();


        $rentorder = RentOrder::create([
            'user_id' => Auth::user()->id,
            ////'username' => Auth::user()->username,
            ////'phone_number' => Auth::user()->phone_number,
            ////'address' => Auth::user()->address,
            'merchant_id' => $rentitem->merchant_id,    //$namamerchant->merchant_name,
            'pet_id' => $rentitem->pet_id,
            'rent_item_id' => $id,
            'rent_order_start' => $request->rent_order_start,
            'rent_order_return' => $request->rent_order_return,
            'rent_order_duration' => count($date_duration),
            'rent_order_notes' => $request->rent_order_notes,
            'shipping_id' =>$request->shipping_id,
            ////'shipping_type' => $ships->shipping_type,
            'payments_option_id' => $request->payments_option_id,
            ////'payments_option' => $payms->payment_type,
            'rent_order_notes' =>$request->rent_order_notes,
            'grand_total_order' => $totalorder,
            // 'pet_id' => $id,
            // 'qty' => $request->qty,
            // 'description' => $request->description,
            // 'merchant_id' => $request->merchant_id,
            'rent_order_status' => "BELUM DIKONFIRMASI"
            // 'user_address' => $alamat->address,
            // 'adoption_item_price' => $request->adoption_item_price,
        ]);

        $rentorderjoin = Rentorder::leftjoin('users','users.id', 'rent_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'rent_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'rent_order.merchant_id')
        ->select('rent_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('rent_order.id',$rentorder->id)
        ->get();
        // dd($rentorderjoin);

        $data = [
            'message' => 'Success',
            'data' => $rentorderjoin
        ];     
        return response()->json($data, 200);
    }


    public function rentorder_getdetail(Request $request, $id)
    {
        // $rentorder = rentOrder::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $rentorder = RentOrder::findOrFail($id);
        if (!$rentorder) {
            $data = [
                'message' => 'rent order not found'
            ];
            return response()->json($data, 404);
        }

        $rentorderjoin = Rentorder::leftjoin('users','users.id', 'rent_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'rent_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'rent_order.merchant_id')
        ->select('rent_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('rent_order.id', $id)
        // ->where('rent_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($rentorderjoin, 200);
    }

    public function rentorder_getall(Request $request)
    {

        $rentorder = rentOrder::where('user_id', Auth::user()->id)->get();

        if (!$rentorder) {
            $data = [
                'message' => 'rent order not found'
            ];
            return response()->json($data, 404);
        }

        $rentorderjoin = Rentorder::leftjoin('users','users.id', 'rent_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'rent_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'rent_order.merchant_id')
        ->select('rent_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('rent_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($rentorderjoin, 200);
    }


    public function rentorder_cancel(Request $request, $id)
    {
        $rentorder = rentOrder::findOrFail($id);
        if (!$rentorder) {
            $data = [
                'message' => 'rent order not found'
            ];
            return response()->json($data, 404);
        }

        $rentorder->update(['rent_order_status' => 'CANCELLED']);

        $rentorderjoin = Rentorder::leftjoin('users','users.id', 'rent_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'rent_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'rent_order.merchant_id')
        ->select('rent_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name')
        ->where('rent_order.id', $id)
        // ->where('rent_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json([
            'status' => 200,
            'message' =>'Cancel rent order success',
            'data' => $rentorderjoin
        ]);
    }
}
