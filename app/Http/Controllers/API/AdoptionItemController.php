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

        $adoptionitemjoin = Adoptionitem::leftjoin('users','users.id', 'adoption_item.user_id')
        ->select('adoption_item.*','users.username', 'users.phone_number', 'users.address')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_item.pet_id')
        ->select('adoption_item.*','users.username', 'users.phone_number', 'users.address', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->where('adoption_item.user_id', Auth::user()->id) //ini buat get semua itemnya
        ->get();
        // dd($adoptionitemjoin);

        $data = [
            'message' => 'Success',
            'data' => $adoptionitemjoin
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

        $adoptionitemjoin = Adoptionitem::leftjoin('users','users.id', 'adoption_item.user_id')
        ->select('adoption_item.*','users.username', 'users.phone_number', 'users.address')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_item.pet_id')
        ->select('adoption_item.*','users.username', 'users.phone_number', 'users.address', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->where('adoption_item.id',$adoptionitem->id)
        ->get();
        // dd($adoptionitemjoin);

        $data = [
            'message' => 'Success',
            'data' => $adoptionitemjoin
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

        $adoptionitemjoin = Adoptionitem::leftjoin('users','users.id', 'adoption_item.user_id')
        ->select('adoption_item.*','users.username', 'users.phone_number', 'users.address')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_item.pet_id')
        ->select('adoption_item.*','users.username', 'users.phone_number', 'users.address', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->where('adoption_item.id',$adoptionitem->id)
        ->get();
        // dd($adoptionitemjoin);
            
        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $adoptionitemjoin
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

        $adoptionitemjoin = Adoptionitem::leftjoin('users','users.id', 'adoption_item.user_id')
        ->select('adoption_item.*','users.username', 'users.phone_number', 'users.address')
        ->leftjoin('pet_profile','pet_profile.id', 'adoption_item.pet_id')
        ->select('adoption_item.*','users.username', 'users.phone_number', 'users.address', 'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 'pet_profile.pet_breed')
        ->where('adoption_item.user_id', Auth::user()->id) //ini buat get semua itemnya
        ->get();
        // dd($adoptionitemjoin);

        $data = [
            'message' => 'Success',
            'data' => $adoptionitemjoin
        // $data = [
        //     'message' => 'Success',
        //     'data' => $alladoptionitem
        ];
        return response()->json($data, 200);
    }
}

