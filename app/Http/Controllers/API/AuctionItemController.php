<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;
use Auth;

class AuctionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pet_group_name' => 'required'
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $auctionitem = AuctionItem::create([
            'user_id' => Auth::user()->id,
            'pet_group_name' => $request->pet_group_name
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
    public function update(Request $request, $id)
    {
        $auctionitem = AuctionItem::where('user_id', Auth::user()->id)->where('id', $id)->first();

        $dataInput = $request->all();

        // dd($request);
        $auctionitem->fill($dataInput)->save();

        $data = [
            'message' => 'Success',
            'data' => $auctionitem
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
