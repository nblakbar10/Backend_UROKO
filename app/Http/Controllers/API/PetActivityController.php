<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetActivity;
use App\Models\PetGroup;
use App\Models\PetProfile;
use Auth;
use Illuminate\Support\Facades\Validator;

class PetActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function pet_activity_by_user()
    {
        $petActivity = PetActivity::leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_activity.pet_group_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'pet_activity.pet_id');
        })
        ->select('pet_activity.*',
                 'pet_grouping.user_id', 
                 'pet_grouping.pet_group_name', 
                 'pet_profile.pet_name', 
                 'pet_profile.user_id', 
                 'pet_profile.pet_group_id', 
                 'pet_profile.pet_species', 
                 'pet_profile.pet_breed', 
                 'pet_profile.pet_morph', 
                 'pet_profile.pet_birthdate', 
                 'pet_profile.pet_age', 
                 'pet_profile.pet_description', 
                 'pet_profile.pet_picture', 
                 'pet_profile.pet_status')
        ->where('pet_activity.user_id', Auth::user()->id)
        ->get();

        $data = [
            'message' => 'Success',
            'data' => $petActivity
        ];
        
        return response()->json($data, 200);
    }

    public function pet_activity_by_group($id)
    {
        $petActivity = PetActivity::leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_activity.pet_group_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'pet_activity.pet_id');
        })
        ->select('pet_activity.*',
                 'pet_grouping.user_id', 
                 'pet_grouping.pet_group_name', 
                 'pet_profile.pet_name', 
                 'pet_profile.user_id', 
                 'pet_profile.pet_group_id', 
                 'pet_profile.pet_species', 
                 'pet_profile.pet_breed', 
                 'pet_profile.pet_morph', 
                 'pet_profile.pet_birthdate', 
                 'pet_profile.pet_age', 
                 'pet_profile.pet_description', 
                 'pet_profile.pet_picture', 
                 'pet_profile.pet_status')
        ->where('pet_activity.user_id', Auth::user()->id)
        ->where('pet_activity.pet_group_id', $id)
        ->get();
        
        $data = [
            'message' => 'Success',
            'data' => $petActivity
        ];
        
        return response()->json($data, 200);
    }

    public function pet_activity_by_petid($group_id,$pet_id)
    {
        $petActivity = PetActivity::leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_activity.pet_group_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'pet_activity.pet_id');
        })
        ->select('pet_activity.*',
                 'pet_grouping.user_id', 
                 'pet_grouping.pet_group_name', 
                 'pet_profile.pet_name', 
                 'pet_profile.user_id', 
                 'pet_profile.pet_group_id', 
                 'pet_profile.pet_species', 
                 'pet_profile.pet_breed', 
                 'pet_profile.pet_morph', 
                 'pet_profile.pet_birthdate', 
                 'pet_profile.pet_age', 
                 'pet_profile.pet_description', 
                 'pet_profile.pet_picture', 
                 'pet_profile.pet_status')
        ->where('pet_activity.user_id', Auth::user()->id)
        ->where('pet_activity.pet_group_id', $group_id)
        ->where('pet_activity.pet_id', $pet_id)
        ->get();
        
        $data = [
            'message' => 'Success',
            'data' => $petActivity
        ];
        
        return response()->json($data, 200);
    }
    // public function index()
    // {
    //     $petGroup = PetGroup::where('user_id', Auth::user()->id)->get();
    //     if (count($petGroup)==0) {
    //         $data = [
    //             'message' => 'Anda tidak memiliki Pet Group'
    //         ];

    //         return response()->json($data, 200);
    //     }

    //     $array = [];
    //     foreach ($petGroup as $key => $value) {
    //         array_push($array, $value);
    //     }
    //     $data = [
    //         'message' => 'Success',
    //         'data' => $array
    //     ];     

    //     return response()->json($data, 200);
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function post_pet_activity(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pet_activity_detail' => 'required',
            'pet_activity_date' => 'required',
            'pet_activity_image' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }
        
        $file_pet_activity_image = $request->pet_activity_image;
        $fileName_pet_activity_image = time().'_'.$file_pet_activity_image->getClientOriginalName();
        $file_pet_activity_image->move(public_path('storage/gambar-activity'), $fileName_pet_activity_image);

        $pet = PetProfile::find($id);

        $petActivity = PetActivity::create([
            'pet_group_id' => $pet->pet_group_id,
            'user_id' => Auth::user()->id,
            'pet_id' => $id,
            'pet_activity_detail' => $request->pet_activity_detail,
            'pet_activity_type' => $request->pet_activity_type,
            'pet_activity_date' => $request->pet_activity_date,
            'pet_activity_image' => $fileName_pet_activity_image
        ]);

        $data = [
            'message' => 'Success',
            'data' => $petActivity
        ];  
        return response()->json($data, 200);
    }

    public function update_pet_activity(Request $request, $id)
    {
        $petActivity = PetActivity::find($id);
        $dataInput = $request->all();

        if ($petActivity == NULL) {
            $data = [
                'message' => 'Success',
                'data' => 'Pet tidak ditemukan'
            ];  
            return response()->json($data, 200);
        }

        if ($request->pet_activity_image != NULL) {
            $file_pet_activity_image = $request->pet_activity_image;
            $fileName_pet_activity_image = time().'_'.$file_pet_activity_image->getClientOriginalName();
            $file_pet_activity_image->move(public_path('storage/gambar-activity'), $fileName_pet_activity_image);

            
            $petActivity->fill($dataInput)->save();
            $petActivity->update([
                'pet_activity_image' => $fileName_pet_activity_image
            ]);

            $data = [
                'message' => 'Success',
                'data' => $petActivity
            ];  
            return response()->json($data, 200);
        }
        
        $petActivity->fill($dataInput)->save();

        $data = [
            'message' => 'Success',
            'data' => $petActivity
        ];  
        return response()->json($data, 200);
    }

    public function delete_pet_activity(Request $request, $id)
    {
        $petActivity = PetActivity::find($id);
        $petActivity->delete();

        $data = [
            'message' => 'Success',
            'data' => 'Berhasil menghapus pet activity'
        ];  
        return response()->json($data, 200);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $petActivity = PetActivity::where('user_id', Auth::user()->id)->where('id', $id)->first();

    //     $dataInput = $request->all();

    //     // dd($request);
    //     $petActivity->fill($dataInput)->save();

    //     $data = [
    //         'message' => 'Success',
    //         'data' => $petActivity
    //     ];

    //     return response()->json($data, 200);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $petActivity = PetActivity::where('user_id', Auth::user()->id)->where('id', $id)->first();
    //     $petActivity->delete();
    //     $data = [
    //         'message' => 'Success',
    //         'data' => 'Berhasil menghapus data'
    //     ];
    //     return response()->json($data, 200);
    // }

    // public function detail_activity_by_user()
    // {
    //     $petActivity = PetActivity::where('user_id', Auth::user()->id)->where('id', $id)->first();

    //     // $array = [];
    //     // foreach ($petActivity as $key => $value) {
    //     //     $pet = PetProfile::where('id', $value->pet_id)->first();
    //     //     $arr = [
    //     //         'name_pet' => $pet->pet_name,
    //     //         'activity' => $value->pet_activity_detail,
    //     //         'date' => $value->pet_activity_date,
    //     //     ];
    //     //     array_push($array, $arr);
    //     // }

    //     $data = [
    //         'message' => 'Success',
    //         'data' => $petActivity
    //     ];  
    //     return response()->json($data, 200);
    // }

    // public function group_activity($id)
    // {
    //     $petActivity = PetActivity::where('user_id', Auth::user()->id)->where('pet_group_id', $id)->get();

    //     $array = [];
    //     foreach ($petActivity as $key => $value) {
    //         $pet = PetProfile::where('id', $value->pet_id)->first();
    //         $arr = [
    //             'name_pet' => $pet->pet_name,
    //             'activity' => $value->pet_activity_detail,
    //             'date' => $value->pet_activity_date,
    //         ];
    //         array_push($array, $arr);
    //     }

    //     $data = [
    //         'message' => 'Success',
    //         'data' => $array
    //     ];  
    //     return response()->json($data, 200);
    // }
}
