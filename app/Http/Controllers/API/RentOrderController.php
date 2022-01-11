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

        // $stringtodate = 

        $begin = new DateTime($request->rent_order_start);
        $end = new DateTime($request->rent_order_return);
        // $end = $end->modify( '+1 day' );

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        $countdate = 0;
        foreach($daterange as $data)
        {
            // $countdate = +1;
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

        $data = [
            'message' => 'Success',
            'data' => $rentorder
        ];     

        return response()->json($data, 200);
    }
}
