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
    public function index()
    {
        $petGroup = PetGroup::where('user_id', Auth::user()->id)->get();
        if (count($petGroup)==0) {
            $data = [
                'message' => 'Anda tidak memiliki Pet Group'
            ];

            return response()->json($data, 200);
        }

        $array = [];
        foreach ($petGroup as $key => $value) {
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
            'pet_group_id' => 'required',
            'pet_id' => 'required',
            'pet_activity_detail' => 'required',
            'pet_activity_date' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $petActivity = PetActivity::create([
            'pet_group_id' => $request->pet_group_id,
            'user_id' => Auth::user()->id,
            'pet_id' => $request->pet_id,
            'pet_activity_detail' => $request->pet_activity_detail,
            'pet_activity_date' => $request->pet_activity_date
        ]);

        $data = [
            'message' => 'Success',
            'data' => $petActivity
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
        $petActivity = PetActivity::where('user_id', Auth::user()->id)->where('id', $id)->first();

        $dataInput = $request->all();

        // dd($request);
        $petActivity->fill($dataInput)->save();

        $data = [
            'message' => 'Success',
            'data' => $petActivity
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
        $petActivity = PetActivity::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $petActivity->delete();

        
        $allPetActivity = PetActivity::where('user_id', Auth::user()->id)->get();
        $data = [
            'message' => 'Success',
            'data' => $allPetActivity
        ];
        return response()->json($data, 200);
    }

    public function detail_activity($id)
    {
        $petActivity = PetActivity::where('user_id', Auth::user()->id)->where('id', $id)->first();

        // $array = [];
        // foreach ($petActivity as $key => $value) {
        //     $pet = PetProfile::where('id', $value->pet_id)->first();
        //     $arr = [
        //         'name_pet' => $pet->pet_name,
        //         'activity' => $value->pet_activity_detail,
        //         'date' => $value->pet_activity_date,
        //     ];
        //     array_push($array, $arr);
        // }

        $data = [
            'message' => 'Success',
            'data' => $petActivity
        ];  
        return response()->json($data, 200);
    }

    public function group_activity($id)
    {
        $petActivity = PetActivity::where('user_id', Auth::user()->id)->where('pet_group_id', $id)->get();

        $array = [];
        foreach ($petActivity as $key => $value) {
            $pet = PetProfile::where('id', $value->pet_id)->first();
            $arr = [
                'name_pet' => $pet->pet_name,
                'activity' => $value->pet_activity_detail,
                'date' => $value->pet_activity_date,
            ];
            array_push($array, $arr);
        }

        $data = [
            'message' => 'Success',
            'data' => $array
        ];  
        return response()->json($data, 200);
    }
}
