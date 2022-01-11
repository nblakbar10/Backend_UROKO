<?php

namespace App\Http\Controllers\API;
use App\Models\AuctionOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use App\Models\User;
use App\Models\PetProfile;
use App\Models\Merchant;
use App\Models\AuctionItem;
use Illuminate\Support\Facades\Validator;

class AuctionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function auctionorder_post(Request $request, $id)
    {
        $auctionitem = AuctionItem::findOrFail($id);
        if (!$auctionitem) {
            $data = [
                'message' => 'auction item not found'
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            // 'qty' => 'required',
            'bid_order_set' => 'required',
            'bid_order_notes' => 'required',
            'shipping_id' => 'required',
            'payments_option_id' => 'required',
            // 'grand_total_order' => 


        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        ////$namamerchant = Merchant::find($id);
        $auctprice = AuctionItem::find($id)->auction_item_price;

        $totalorder = $auctprice + 4500;
        ////$payms = PaymentsOption::find($id);
        ////$ships = Shipping::find($id);

        $auctionorder = AuctionOrder::create([
            'user_id' => Auth::user()->id,
            ////'username' => Auth::user()->username,
            ////'phone_number' => Auth::user()->phone_number,
            ////'address' => Auth::user()->address,
            'auction_item_id' => $id,
            'merchant_id' => $auctionitem->merchant_id,    //$namamerchant->merchant_name,
            'pet_id' => $auctionitem->pet_id,
            'shipping_id' => $request->shipping_id,
            'bid_order_set' => $request->bid_order_set,
            'bid_order_notes' =>$request->bid_order_notes,
            ////'shipping_type' => $ships->shipping_type,
            'payments_option_id' => $request->payments_option_id,
            ////'payments_option' => $payms->payment_type,
            'grand_total_order' => $totalorder,
            // 'pet_id' => $id,
            // 'qty' => $request->qty,
            // 'description' => $request->description,
            // 'merchant_id' => $request->merchant_id,
            'bid_order_status' => "BELUM DIKONFIRMASI"
            // 'user_address' => $alamat->address,
            // 'adoption_item_price' => $request->adoption_item_price,
        ]);

        $auctionorderjoin = AuctionOrder::leftjoin('users','users.id', 'auction_order.user_id')
        ->select('auction_order.*','users.username', 'users.phone_number', 'users.address')
        ->where('auction_order.id',$auctionorder->id)
        ->get();
        // dd($auctionorderjoin);

        $data = [
            'message' => 'Success',
            'data' => $auctionorderjoin
        ];     
        return response()->json($data, 200);
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
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function show(Auction $auction)
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
    public function update(Request $request, Auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        //
    }


    public function auctionorder_getdetail(Request $request, $id)
    {
        // $auctionorder = auctionOrder::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $auctionorder = AuctionOrder::findOrFail($id);
        if (!$auctionorder) {
            $data = [
                'message' => 'auction order not found'
            ];
            return response()->json($data, 404);
        }

        $auctionorderjoin = AuctionOrder::leftjoin('users','users.id', 'auction_order.user_id')
        ->select('auction_order.*','users.username', 'users.phone_number', 'users.address')
        ->where('auction_order.id', $id)
        // ->where('auction_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($auctionorderjoin, 200);
    }

    public function auctionorder_getall(Request $request)
    {

        $auctionorder = AuctionOrder::where('user_id', Auth::user()->id)->get();
        // $adoptionorder = AdoptionOrder::where('user_id', Auth::user()->id)->where('id', $id)->first();
        // $adoptionorder = AdoptionOrder::findOrFail($id);
        if (!$auctionorder) {
            $data = [
                'message' => 'auction order not found'
            ];
            return response()->json($data, 404);
        }

        $auctionorderjoin = AuctionOrder::leftjoin('users','users.id', 'auction_order.user_id')
        ->select('auction_order.*','users.username', 'users.phone_number', 'users.address')
        ->where('auction_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($auctionorderjoin, 200);
    }

    public function auctionorder_cancel(Request $request, $id)
    {
        $auctionorder = auctionOrder::findOrFail($id);
        if (!$auctionorder) {
            $data = [
                'message' => 'auction order not found'
            ];
            return response()->json($data, 404);
        }

        $auctionorder->update(['bid_order_status' => 'CANCELLED']);

        return response()->json([
            'status' => 200,
            'message' =>'Cancel auction order success',
            'data' => $auctionorder
        ]);
    }
}
