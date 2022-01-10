<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use App\Models\User;
use App\Models\AdoptionItem;
use App\Models\PetProfile;
use App\Models\Merchant;
use Illuminate\Support\Facades\Validator;

class AdoptionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adoptionitem_index()
    {
        $adoptionitem = AdoptionItem::where('user_id', Auth::user()->id)->get();

        if (count($adoptionitem)==0) {
            $data = [
                'message' => 'Anda tidak memiliki adoption item'
            ];

            return response()->json($data, 200);
        }

        $array = [];
        foreach ($adoptionitem as $key => $value) {
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
    public function adoptionitem_post(Request $request, $id)
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

        // // $data = [
        // //     'message' => 'Success',
        // //     'data' => $merchant
        // // ];

        // // return response()->json($data, 200);

        //jika ada merchant, maka langsung arahkan ke input adoptionitem
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
            'adoption_item_price' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $adoptionitem = AdoptionItem::create([
            'user_id' => Auth::user()->id,
            'pet_id' => $id,
            'qty' => $request->qty,
            'description' => $request->description,
            // 'merchant_id' => $merchant->id,
            'merchant_id' => $request->merchant_id,
            'adoption_item_price' => $request->adoption_item_price,

        ]);

        $data = [
            'message' => 'Success',
            'data' => $adoptionitem
        ];     

        return response()->json($data, 200);
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
    public function adoptionitem_edit(Request $request, $id)
    {

        $adoptionitem = AdoptionItem::find($id);
        $adoptionitem->update($request->all());
        return response()->json([
            'status' => 200,
            "message" => "edit adoptionitem sukses",
            "data" => $adoptionitem
        ]);

        // $adoptionitem = AdoptionItem::where('user_id', Auth::user()->id)->where('id', $id)->first();

        // $dataInput = $request->all();

        // // dd($request);
        // $adoptionitem->fill($dataInput)->save();

        // $data = [
        //     'message' => 'Success',
        //     'data' => $adoptionitem
        // ];

        // return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adoptionitem_delete($id)
    {
        
        $adoptionitem = AdoptionItem::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $adoptionitem->delete();

        
        $alladoptionitem = AdoptionItem::where('user_id', Auth::user()->id)->get();
        $data = [
            'message' => 'Success',
            'data' => $alladoptionitem
        ];
        return response()->json($data, 200);
    }
}

