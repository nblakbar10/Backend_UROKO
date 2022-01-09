<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PetActivity;
use App\Models\PetGroup;
use App\Models\PetProfile;
use Auth;

use Illuminate\Support\Facades\Validator;

class PetGroupController extends Controller
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
            'pet_group_name' => 'required'
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $petGroup = PetGroup::create([
            'user_id' => Auth::user()->id,
            'pet_group_name' => $request->pet_group_name
        ]);

        $data = [
            'message' => 'Success',
            'data' => $petGroup
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
        $petGroup = PetGroup::where('user_id', Auth::user()->id)->where('id', $id)->first();

        $dataInput = $request->all();

        // dd($request);
        $petGroup->fill($dataInput)->save();

        $data = [
            'message' => 'Success',
            'data' => $petGroup
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
        $petGroup = PetGroup::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $petGroup->delete();

        
        $allPetGroup = PetGroup::where('user_id', Auth::user()->id)->get();
        $data = [
            'message' => 'Success',
            'pet_group_remaining' => $allPetGroup
        ];
        return response()->json($data, 200);
    }

    public function detail_group($id)
    {
        $petGroup = PetGroup::where('user_id', Auth::user()->id)->where('id', $id)->first();

        $petArr = [];

        $pet = PetProfile::where('pet_group_id', $petGroup->id)->get();
        foreach ($pet as $key => $value) {
            array_push($petArr, $value);
        }
        $array = [
            'pet_group_name' => $petGroup->pet_group_name,
            'list_pet' => $petArr
        ];
        $data = [
            'message' => 'Success',
            'data' => $array
        ];  
        return response()->json($data, 200);
    }
}
