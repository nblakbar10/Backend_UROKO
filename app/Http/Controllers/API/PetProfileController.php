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
            // 'pet_group_id' => 'required',
            'pet_gender' => 'required',
            'pet_size' => 'required',
            'pet_weight' => 'required',
            'pet_species' => 'required',
            'pet_breed' => 'required',
            'pet_morph' => 'required',
            'pet_birthdate' => 'required',
            'pet_age' => 'required',
            'pet_description' => 'required',
            'pet_picture' => 'required',
            'pet_picture.*' => 'mimes:jpeg,jpg,png',//'mimes:jpeg,jpg,png|required|max:10000',
            'pet_status' => 'required',
            // 'pet_activity_id'  => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $data = [];
        if($request->hasfile('pet_picture'))
        {
            foreach($request->file('pet_picture') as $petprofile)
            {
                $host = $request->getSchemeAndHttpHost();
            //    $name=$file->getClientOriginalName();
                $fileName_petPicture = $host.'/storage/gambar-pet/'.time().'_'.$petprofile->getClientOriginalName();
            //    $file->move(public_path().'/files/', $name);  
                $petprofile->move(public_path('storage/gambar-pet'), $fileName_petPicture);
                $data[] = $fileName_petPicture;  
            }
        }

        $petProfile = new PetProfile();
        $petProfile->pet_name = $request->pet_name;
        $petProfile->pet_group_id = $request->pet_group_id;
        $petProfile->user_id = Auth::user()->id;
        $petProfile->pet_gender = $request->pet_gender;
        $petProfile->pet_size = $request->pet_size;
        $petProfile->pet_weight = $request->pet_weight;
        $petProfile->pet_species = $request->pet_species;
        $petProfile->pet_breed = $request->pet_breed;
        $petProfile->pet_morph = $request->pet_morph;
        $petProfile->pet_birthdate = $request->pet_birthdate;
        $petProfile->pet_age = $request->pet_age;
        $petProfile->pet_description = $request->pet_description;
        $petProfile->pet_picture = $data;
        $petProfile->pet_status = $request->pet_status;
        $petProfile->save();
        // // $fileName_petPicture->pet_picture=json_encode($data);

        // // $host = $request->getSchemeAndHttpHost();
        // // $file_pet_picture = $request->pet_picture;
        // // $fileName_petPicture = $host.'/storage/gambar-pet/'.time().'_'.$file_pet_picture->getClientOriginalName();
        // // $file_pet_picture->move(public_path('storage/gambar-pet'), $fileName_petPicture);

        // $petProfile = PetProfile::create([
        //     'pet_name' => $request->pet_name,
        //     'pet_group_id' => $request->pet_group_id,
        //     'user_id' => Auth::user()->id,
        //     'pet_species' => $request->pet_species,
        //     'pet_breed' => $request->pet_breed,
        //     'pet_morph' => $request->pet_morph,
        //     'pet_birthdate' => $request->pet_birthdate,
        //     'pet_age' => $request->pet_age,
        //     'pet_description' => $request->pet_description,
        //     'pet_picture' => $data, //$fileName_petPicture,
        //     'pet_status' => $request->pet_status,
        
        // ]);

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
        // dd($request->merchant_image);
        if ($request->pet_picture  == NULL) {
            $dataInput = $request->all();
            $pet->fill($dataInput)->save();

            return response()->json($data, 200);
            // return redirect()->back()->with('success', 'Berhasil melakukan update merchant');
        } else {

            $host = $request->getSchemeAndHttpHost();
            $file_pet_picture = $request->pet_picture;
            $fileName_petPicture = $host.'/storage/gambar-pet/'.time().'_'.$file_pet_picture->getClientOriginalName();
            $file_pet_picture->move(public_path('storage/gambar-pet'), $fileName_petPicture);

            $pet->update([
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
            ]);

            return response()->json($pet, 200);
        }
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
            'pet_remaining' => $allPet
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
