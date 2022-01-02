<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\Datatables\Datatables;

class ManajemenUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.User.index');
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

    public function get_user(Request $request)
    {
        $user = User::leftJoin('merchant', function ($join) {
            $join->on('merchant.id_user', '=', 'users.id');
        })->select('merchant.merchant_name', 'users.*');

        $datatables = Datatables::of($user);

        if ($request->get('search')['value']) {
            $datatables->filter(function ($query) {
                    $keyword = request()->get('search')['value'];
                    $query->where('name', 'like', "%" . $keyword . "%");

        });}

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('merchant.updated_at', $order);
        });

        return $datatables->addIndexColumn()
        ->addColumn('action','Admin.User.action')
        ->addColumn('profile_img','Admin.User.profile-img')
        ->toJson();
    }
}
