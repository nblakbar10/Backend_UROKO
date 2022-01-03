<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Merchant;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        if (!$merchant) {
            $merchant = "Belum ada Merchant!";
        }

        $data = [
            'message' => 'Success',
            'data' => $merchant
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
        // dd($request);
        $validator = Validator::make($request->all(), [
            'merchant_name' => 'required',
            'merchant_image' => 'mimes:jpeg,jpg,png|required|max:10000'
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        if (!$merchant) {
            $file_merchant_image = $request->merchant_image;
            $fileName_merchantImage = time().'_'.$file_merchant_image->getClientOriginalName();
            $file_merchant_image->move(public_path('storage/gambar-merchant'), $fileName_merchantImage);

            $merchant = Merchant::create([
                'user_id' => Auth::user()->id,
                'merchant_name' => $request->merchant_name,
                'merchant_image' => $fileName_merchantImage,
            ]);
    
            $data = [
                'message' => 'Success',
                'data' =>$merchant
            ];
    
            if ($merchant) {
                return response()->json($data, 200);
            }
        } else {
            $data = [
                'message' => 'Failed',
                'data' => 'Anda sudah memiliki Merchant'
            ];
    
            if ($merchant) {
                return response()->json($data, 400);
            }
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
