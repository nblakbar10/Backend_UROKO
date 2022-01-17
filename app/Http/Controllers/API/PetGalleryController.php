<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetGallery;
use App\Models\PetActivity;
use App\Models\PetGroup;
use App\Models\PetProfile;
use App\Models\PetActivityLikeComment;
use Auth;
use Illuminate\Support\Facades\Validator;

class PetGalleryController extends Controller
{
    public function get_album()
    {
        $album = PetGallery::all();

        return response()->json([
            'message' => 'Success',
            'data' => $album
        ], 200);
    } 

    public function get_gallery_by_album_id($album_id)
    {
        $petActivity = PetActivity::leftjoin('pet_profile', 'pet_profile.id', 'pet_activity.pet_id')
        ->leftjoin('pet_gallery', 'pet_gallery.id', 'pet_profile.album_id')
        ->where('pet_gallery.id', $album_id)
        ->select('pet_activity.*',
                 'pet_profile.album_id',
                 'pet_gallery.album_name')
        ->get();

        foreach ($petActivity as $key => $value) {
            $arr['pet_activity_id'] = $value->id;
            $arr['pet_activity_detail'] = $value->pet_activity_detail;
            $arr['pet_activity_image'] = $value->pet_activity_image;
        }

        $data = [
            'album_id' => $album_id,
            'album_name' => $petActivity->album_name,
            'detail_data' => $arr
        ];
        return response()->json([
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    public function post_album(Request $request)
    {
        $searchAlbum = PetGallery::where('album_name', $request->pet_name)->where('user_id', Auth::user()->id)->first();
        // $albumID = $searchAlbum->id;
        if ($searchAlbum == NULL) {    
            $album = PetGallery::create([
                'user_id' => Auth::user()->id,
                'album_name' => $request->pet_name,
                'album_name' => $data[0]
            ]);

            return response()->json([
                'message' => 'Success',
                'data' => $album
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed',
                'data' => 'Album sudah ada'
            ], 403);
        }
    }

    public function insert_pet_to_album($pet_id, $album_id)
    {
        $pet = PetProfile::find($pet_id);
        $pet->update([
            'album_id' => $album_id
        ]);

        return response()->json([
            'message' => 'Success',
            'data' => $pet
        ], 200);
    }
}
