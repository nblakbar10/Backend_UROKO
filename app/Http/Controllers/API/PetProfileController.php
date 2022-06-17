<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetProfile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PetGallery;

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
        
        // $leftjoininfoalbum = PetProfile::find('album_id');

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
            'data' => $array,
            // 'data_album' => $leftjoininfoalbum //untuk show data album
        ];     

        return response()->json($data, 200);
    }

    public function pet_profile_for_another_user(Request $request, $owner_id)
    {
        $pet = PetProfile::where('user_id', $owner_id)
        ->orwhere('pet_status', 'PUBLIC')
        ->get();

        if (count($pet)==0) {
            $data = [
                'message' => 'User ini tidak memiliki pet'
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
            'pet_picture' => 'required|mimes:jpeg,jpg,png',
            // 'pet_picture' => 'required',
            // 'pet_picture.*' => 'mimes:jpeg,jpg,png',//'mimes:jpeg,jpg,png|required|max:10000',
            'pet_status' => 'required', //PUBLIC or PRIVATE
            // 'pet_activity_id'  => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        
        $host = $request->getSchemeAndHttpHost();
        $petprofile = $request->pet_picture;
        $fileName_petPicture = time().'_'.$petprofile->getClientOriginalName();
        $fileName_petPicture2 = $host.'/storage/gambar-pet/'.$fileName_petPicture;
        $petprofile->move(public_path('storage/gambar-pet'), $fileName_petPicture);

        // dd(parse_url($fileName_petPicture, PHP_URL_PATH));
        // $v = $this->save_album($fileName_petPicture, $request->pet_picture); 

        
        // $file = $fileName_petPicture;
        // $destination = public_path('storage/gambar-album');
        // Storage::get('public/'.$fileName_petPicture);

        // $data = [];
        // if($request->hasfile('pet_picture'))
        // {
        //     foreach($request->file('pet_picture') as $petprofile)
        //     {
        //         $host = $request->getSchemeAndHttpHost();
        //     //    $name=$file->getClientOriginalName();
        //         $fileName_petPicture = $host.'/storage/gambar-pet/'.time().'_'.$petprofile->getClientOriginalName();
        //     //    $file->move(public_path().'/files/', $name);  
        //         $petprofile->move(public_path('storage/gambar-pet'), $fileName_petPicture);
        //         $data[] = $fileName_petPicture;  
        //     }
        // }
        $searchAlbum = PetGallery::where('album_name', $request->pet_name)->where('user_id', Auth::user()->id)->first();
        
        if ($searchAlbum == NULL) {    
            $petprofilealbum = $request->pet_picture;
            $petprofilealbum->move(public_path('storage/gambar-album'), $fileName_petPicture);
           
            // $file = public_path('storage/gambar-pet', $fileName_petPicture);
            // $destination = public_path('storage/gambar-album', $fileName_petPicture);
            // Storage::copy($file,$destination);
            
            $album = PetGallery::create([
                'user_id' => Auth::user()->id,
                'album_name' => $request->pet_name,
                'album_picture' => $fileName_petPicture,
                'album_picture2' => $fileName_petPicture2,
                'album_type' => "BY-PROFILE"
            ]);

            $albumID = $album->id;
        }
        else{
            $albumID = $searchAlbum->id;
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
        $petProfile->pet_picture = $fileName_petPicture; //$data;
        $petProfile->pet_picture2 = $fileName_petPicture2; //$data;
        $petProfile->pet_status = $request->pet_status;
        $petProfile->album_id = $albumID;
        $petProfile->save();
        // // $fileName_petPicture->pet_picture=json_encode($data);
        
        $leftjoininfoalbum = PetGallery::find($albumID);
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
            'data_pet' => $petProfile,
            'data_album' => $leftjoininfoalbum
        ];

        $dataresponse = [
            'message' => 'Success',
            'data' => $data
        ];     

        return response()->json($dataresponse, 200);
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
            $fileName_petPicture = time().'_'.$file_pet_picture->getClientOriginalName();
            $fileName_petPicture2 = $host.'/storage/gambar-pet/'.$fileName_petPicture;
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
                'pet_picture2' => $fileName_petPicture2,
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

    // public function save_album($fileName_petPicture, $file){
    //     // $files = Storage::disk('public/gambar-pet')->get($fileName_petPicture);
    //     // // $files = storage_path('public/gambar-pet/'. $fileName_petPicture);
    //     // $destination = public_path('storage/gambar-album', $fileName_petPicture);
    //     // Storage::copy($files,$destination);
    //     // // $file->move(public_path('storage/gambar-album'), $fileName_petPicture);
    //     // // dd($fileName_petPicture);
    //     // return $fileName_petPicture;

    //     $file->move(public_path('storage/gambar-album'), 'fileName_petPicture');
    // }

    public function pet_status_change(Request $request, $pet_id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }
        $pet = PetProfile::where('user_id', Auth::user()->id)->where('id', $pet_id)->first();

        if ($pet) {
            $pet->update([
                'pet_status' => $request->status
            ]);

            
            $data = [
                'message' => 'Failed',
                'data' => $pet
            ];     
    
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Failed',
                'data' => 'Anda tidak memiliki pet ini'
            ];     
    
            return response()->json($data, 404);
        }
        
    }
}