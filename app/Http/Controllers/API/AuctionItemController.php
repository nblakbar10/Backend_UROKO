<?php

namespace App\Http\Controllers\API;
use App\Models\AuctionItem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use App\Models\User;
use App\Models\PetProfile;
use App\Models\Merchant;
use Illuminate\Support\Facades\Validator;

class AuctionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function auctionitem_index()
    {
        $auctionitem = AuctionItem::where('user_id', Auth::user()->id)->get();

        if (count($auctionitem)==0) {
            $data = [
                'message' => 'Anda tidak memiliki Auction Item'
            ];

            return response()->json($data, 200);
        }

        $array = [];
        foreach ($auctionitem as $key => $value) {
            array_push($array, $value);
        }
        $data = [
            'message' => 'Success',
            'data' => $array
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
    public function auctionitem_post(Request $request, $id)
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
            'auction_bid_start' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $auctionitem = AuctionItem::create([
            'user_id' => Auth::user()->id,
            'pet_id' => $id,
            'qty' => $request->qty,
            'description' => $request->description,
            // 'merchant_id' => $merchant->id,
            'merchant_id' => $request->merchant_id,
            'auction_bid_start' => $request->auction_bid_start,

        ]);

        $data = [
            'message' => 'Success',
            'data' => $auctionitem
        ];     

        return response()->json($data, 200);
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
    public function auctionitem_edit(Request $request, $id)
    {

        $auctionitem = AuctionItem::find($id);
        $auctionitem->update($request->all());
        return response()->json([
            'status' => 200,
            "message" => "edit auctionitem sukses",
            "data" => $auctionitem
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function auctionitem_delete($id)
    {
        $auctionitem = AuctionItem::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $auctionitem->delete();

        
        $allauctionitem = AuctionItem::where('user_id', Auth::user()->id)->get();
        $data = [
            'message' => 'Success',
            'data' => $allauctionitem
        ];
        return response()->json($data, 200);
    }
}
