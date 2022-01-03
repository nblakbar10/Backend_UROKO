<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetProfile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;

class PetProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pet = PetProfile::where('user_id', Auth::user()->id)->get();

        if (count($pet)==0) {
            $data = [
                'message' => 'Anda tidak memiliki pet'
            ];

            return response()->json($data, 200);
        }

        $array = [];
        foreach ($pet as $key => $value) {
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
            'pet_name' => 'required',
            'pet_group_id' => 'required',
            'pet_species' => 'required',
            'pet_breed' => 'required',
            'pet_morph' => 'required',
            'pet_birthdate' => 'required',
            'pet_age' => 'required',
            'pet_description' => 'required',
            'pet_picture' => 'mimes:jpeg,jpg,png|required|max:10000',
            'pet_status' => 'required',
            'pet_activity_id'  => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        
        $file_pet_picture = $request->pet_picture;
        $fileName_petPicture = time().'_'.$file_pet_picture->getClientOriginalName();
        $file_pet_picture->move(public_path('storage/gambar-pet'), $fileName_petPicture);

        $petProfile = PetProfile::create([
            'pet_name' => $request->pet_name,
            'pet_group_id' => $request->pet_group_id,
            'user_id' => Auth::user()->id,
            'pet_species' => $request->pet_species,
            'pet_breed' => $request->pet_breed,
            'pet_morph' => $request->pet_morph,
            'pet_birthdate' => $request->pet_birthdate,
            'pet_age' => $request->pet_age,
            'pet_description' => $request->pet_description,
            'pet_picture' => $fileName_petPicture,
            'pet_status' => $request->pet_status,
            'pet_activity_id'  => $request->pet_activity_id,
        ]);

        $data = [
            'message' => 'Success',
            'data' => $petProfile
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
        $pet = PetProfile::where('user_id', Auth::user()->id)->where('id', $id)->first();

        $dataInput = $request->all();

        // dd($request);
        $pet->fill($dataInput)->save();

        $data = [
            'message' => 'Success',
            'data' => $pet
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pet = PetProfile::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $pet->delete();

        
        $allPet = PetProfile::where('user_id', Auth::user()->id)->get();
        $data = [
            'message' => 'Success',
            'data' => $allPet
        ];
        return response()->json($data, 200);
    }

    public function detail_pet($id)
    {
        $pet = PetProfile::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if ($pet == NULL) {
            $data = [
                'message' => 'Pet tidak ada'
            ];

            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Success',
            'data' => $pet
        ];     

        return response()->json($data, 200);
    }
}
