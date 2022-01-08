<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PetProfile;
use App\Models\PetActivity;
use App\Models\PetGroup;
use Yajra\Datatables\Datatables;

class PetActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('role', 'User')->get();
        return view('Admin.Pet-Activity.index', compact('user'));
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
        //
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

    public function get_activity(Request $request)
    {
        $pet = PetActivity::leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'pet_activity.user_id');
        })
        ->leftJoin('pet_grouping', function ($join) {
            $join->on('pet_grouping.id', '=', 'pet_activity.pet_group_id');
        })
        ->leftJoin('pet_profile', function ($join) {
            $join->on('pet_profile.id', '=', 'pet_activity.pet_id');
        })
        ->select('pet_activity.*', 'users.username', 'pet_grouping.pet_group_name', 'pet_profile.pet_name');

        if ($request->input('username') != null) {
            $pet = $pet->where('pet_activity.user_id', $request->username);
        }
        if ($request->input('group') != null) {
            $pet = $pet->where('pet_activity.pet_group_id', $request->group);
        }
        // if ($request->input('habitats') != null) {
        //     $pet = $dataaset->where('username', $request->username);
        // }

        $datatables = Datatables::of($pet);

        if ($request->get('search')['value']) {
            $datatables->filter(function ($query) {
                    $keyword = request()->get('search')['value'];
                    $query->where('pet_profile.pet_name', 'like', "%" . $keyword . "%");

        });}

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('pet_activity.updated_at', $order);
        });
        return $datatables->addIndexColumn()
        ->escapeColumns([])
        ->addColumn('picture','Admin.Pet-Profile.picture')
        ->toJson();
    }

    public function get_group_activity(Request $request)
    {
        if ($request->username != NULL) {
            $fixdata = PetGroup::where('user_id', $request->username)->get();
            return response()->json([
                'data' => $fixdata,
            ]);
        }
    }
}
