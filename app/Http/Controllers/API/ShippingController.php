<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Response;
use App\Models\User;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        //
    }


    public function shipping_post(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'shipping_type' => 'required',
            'shipping_fee' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $inputshipping = new Shipping();
        $inputshipping->shipping_type = $request->shipping_type;
        $inputshipping->shipping_fee = $request->shipping_fee;
        $inputshipping->save();

        $data = [
            'message' => 'Success',
            'data' => $inputshipping
        ];     

        return response()->json($data, 200);
    }

    public function get_shipping_option()
    {
        $shipping_option = Shipping::orderBy('id', 'desc')->get();
        return response()->json([
            'status' => '200 OK',
            'message' =>'get_shipping_option success',
            'data' => $shipping_option
        ]);
    }
      
}
