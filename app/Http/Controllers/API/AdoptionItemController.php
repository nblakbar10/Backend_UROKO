<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use App\Models\User;
use App\Models\AdoptionItem;
use App\Models\PetProfile;
use Illuminate\Support\Facades\Validator;

class AdoptionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function store(Request $request, $id)
    {
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
            'merchant_id' => 'required',
            'adoption_item_price' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        
        // $file_pet_picture = $request->pet_picture;
        // $fileName_petPicture = time().'_'.$file_pet_picture->getClientOriginalName();
        // $file_pet_picture->move(public_path('storage/gambar-pet'), $fileName_petPicture);

        $adoptionitem = AdoptionItem::create([
            'user_id' => Auth::user()->id,
            'pet_id' => $id,
            'qty' => $request->qty,
            'description' => $request->description,
            'merchant_id' => $request->merchant_id,
            'adoption_item_price' => $adoption_item_price,

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

