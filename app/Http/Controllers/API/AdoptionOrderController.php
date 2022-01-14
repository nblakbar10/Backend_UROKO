<?php

namespace App\Http\Controllers\API;
use App\Models\AdoptionOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use App\Models\User;
use App\Models\PetProfile;
use App\Models\Merchant;
use App\Models\AdoptionItem;
use Illuminate\Support\Facades\Validator;


class AdoptionOrderController extends Controller
{
    public function adoptionorder_post(Request $request, $id)
    {
        $adoptionitem = AdoptionItem::findOrFail($id);
        if (!$adoptionitem) {
            $data = [
                'message' => 'adoption item not found'
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [
            // 'qty' => 'required',
            'adoption_order_notes' => 'required',
            'shipping_id' => 'required',
            'payments_option_id' => 'required',
            // 'grand_total_order' => 
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }
        ////$namamerchant = Merchant::find($id);
        $adoptprice = AdoptionItem::find($id)->adoption_item_price;
        $totalorder = $adoptprice + 4500;
        ////$payms = PaymentsOption::find($id);
        ////$ships = Shipping::find($id);

        $adoptionorder = AdoptionOrder::create([
            'user_id' => Auth::user()->id,
            ////'username' => Auth::user()->username,
            ////'phone_number' => Auth::user()->phone_number,
            ////'address' => Auth::user()->address,
            'adoption_item_id' => $id,
            'merchant_id' => $adoptionitem->merchant_id,    //$namamerchant->merchant_name,
            'pet_id' => $adoptionitem->pet_id,
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
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_order.pet_id')
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->where('adoption_order.id',$adoptionorder->id)
        ->get();
        // dd($adoptionorderjoin);

        $data = [
            'message' => 'Success',
            'data' => $adoptionorderjoin
        ];     
        return response()->json($data, 200);
    }

    public function adoptionorder_getdetail(Request $request, $id)
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
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_order.pet_id')
        //->select('pet_profile.*', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->where('adoption_order.id', $id)
        // ->where('adoption_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($adoptionorderjoin, 200);
    }

    public function adoptionorder_getall(Request $request)
    {

        $adoptionorder = AdoptionOrder::where('user_id', Auth::user()->id)->get();
        if (!$adoptionorder) {
            $data = [
                'message' => 'adoption order not found'
            ];
            return response()->json($data, 404);
        }

        $adoptionorderjoin = AdoptionOrder::leftjoin('users','users.id', 'adoption_order.user_id')
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_order.pet_id')
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->where('adoption_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($adoptionorderjoin, 200);
        
    }

    public function adoptionorder_cancel(Request $request, $id)
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
        ->select('adoption_order.*','users.username', 'users.phone_number', 'users.address', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_order.pet_id')
        //->select('pet_profile.*', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->where('adoption_order.id', $id)
        // ->where('adoption_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json([
            'status' => 200,
            'message' =>'Cancel adoption order success',
            'data' => $adoptionorderjoin
        ]);
    }
}
