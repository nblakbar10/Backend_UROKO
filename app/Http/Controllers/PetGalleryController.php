<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PetProfile;
use App\Models\PetActivity;
use App\Models\PetGallery;

class PetGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::where('role', 'User')->get();

        $petActivity = PetActivity::select('pet_activity.*');

        $user_id = NULL;
        $album_id = NULL;
        $all_album = NULL;

        if ($request->user != NULL) {
            // dd($request->user);
            $user_id=$request->user;
            $all_album = PetGallery::where('user_id', $user_id)->get();
            $petActivity = $petActivity->where('user_id', $request->user)->get();
        } else {
            $petActivity = $petActivity->get();
        }

            // dd($all_album);
        if ($request->user AND $request->album != NULL) {
            $album_id=$request->album;
            $petActivity = PetActivity::leftjoin('pet_profile','pet_profile.id','pet_activity.pet_id')
            ->leftjoin('pet_gallery','pet_gallery.id','pet_profile.album_id')
            ->where('pet_gallery.user_id',$request->user)
            ->where('pet_gallery.id',$request->album)
            ->select('pet_activity.*', 'pet_profile.pet_name')
            ->get();
        }
        
        return view('Admin.Pet-Gallery.index', compact('user','petActivity','user_id','all_album','album_id'));
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
}
