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
use Image;
use Illuminate\Support\Facades\Validator;

class PetGalleryController extends Controller
{
    public function get_album()
    {
        $album = PetGallery::where('user_id', Auth::user()->id)->get(); //authuser
        if (count($album)==0) {
            $album  = "Tidak Ada Album!";
        }

        return response()->json([
            'message' => 'Success',
            'data' => $album
        ], 200);
    } 

    public function get_gallery_by_album_id($album_id)
    {
        $album = PetGallery::find($album_id);
        if (!$album) {
            $data = [
                'message' => 'album not found'
            ];
            return response()->json($data, 404);
        }

        // $petgalleryjoin = PetGallery::leftjoin('pet_activity', 'pet_activity.id', 'pet_profile.album_id')
        // ->leftjoin('pet_profile', 'pet_profile.id', 'pet_activity.pet_id')
        // ->where('pet_profile.album_id', $album_id)
        // ->select('pet_gallery.*',
        
        //          'pet_profile.album_id',
        //          'pet_gallery.album_name',
        //          'pet_gallery.album_picture',
        //          'pet_gallery.album_picture2')
        // ->get();

        $petActivity = PetActivity::leftjoin('pet_profile', 'pet_profile.id', 'pet_activity.pet_id')
        ->leftjoin('pet_gallery', 'pet_gallery.id', 'pet_profile.album_id')
        ->where('pet_profile.album_id', $album_id)
        ->select('pet_activity.*',
                 'pet_profile.album_id',
                 'pet_gallery.album_name',
                 'pet_gallery.album_picture',
                 'pet_gallery.album_picture2')
        ->get();
        // dd($petActivity['user_id']);

        foreach ($petActivity as $key => $value) {
            // dd($value->album_name);
            $arr['pet_activity_id'] = $value->id;
            $arr['pet_activity_detail'] = $value->pet_activity_detail;
            $arr['pet_activity_image'] = $value->pet_activity_image;
            $arr['pet_activity_image2'] = $value->pet_activity_image2;

            $arr_result[] = $arr;
        }

        $petgallery = PetGallery::find($album_id);
        $data = [
            'album_id' => $album_id,
            'album_name' => $petgallery->album_name,
            'album_picture' => $petgallery->album_picture,
            'album_picture2' => $petgallery->album_picture2,
            'detail_data' => $arr_result
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
            $validator = Validator::make($request->all(), [
                'album_name' => 'required',
                'album_picture' => 'required',
                // 'pet_activity_id'  => 'required',
            ]);
    
            if ($validator->fails()) {    
                return response()->json($validator->messages(), 400);
            }

            $host = $request->getSchemeAndHttpHost();
            //    $name=$file->getClientOriginalName();
            $fileName_petPicture = time().'_'.$request->album_picture->getClientOriginalName();
            $fileName_petPicture2 = $host.'/storage/gambar-album/'.$fileName_petPicture;
            //    $file->move(public_path().'/files/', $name);  
            $request->album_picture->move(public_path('storage/gambar-album/'), $fileName_petPicture);
            $album = PetGallery::create([
                'user_id' => Auth::user()->id,
                'album_name' => $request->album_name,
                'album_picture' => $fileName_petPicture,
                'album_picture2' => $fileName_petPicture2,
                'album_type' => "BY-ALBUM",
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

    public function edit_album(Request $request, $album_id)
    {

        $album = PetGallery::find($album_id);

        $dataInput = $request->all();


        if ($request->album_picture != NULL) {
            $host = $request->getSchemeAndHttpHost();
            $file_picture = $request->album_picture;
            $fileName_petPicture = time().'_'.$request->album_picture->getClientOriginalName();
            $fileName_petPicture2 = $host.'/storage/gambar-album/'.$fileName_petPicture;
            $file_picture->move(public_path('storage/gambar-album/'), $fileName_petPicture);
            
            $album->fill($dataInput)->save();
            $album->update([
                'album_picture' => $fileName_petPicture,
                'album_picture2' => $fileName_petPicture2,
            ]);

            $data = [
                'message' => 'Success',
                'data' => $album
            ];  
            return response()->json($data, 200);
        }


        // dd($request);
        $album->fill($dataInput)->save();
        
        $data = [
            'message' => 'Success editing Album',
            'data' => $album
        ];

        return response()->json($data, 200);
    }

    public function delete_album(Request $request, $album_id)
    {
        $album = PetGallery::find($album_id);
        $album->delete();

        $data = [
            'message' => 'Success',
            'data' => 'Berhasil menghapus album'
        ];  
        return response()->json($data, 200);
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

    public function download_image_from_gallery(Request $request,$image_name)
    {
        // dd('Halo');
        $img = Image::make(public_path('storage/gambar-activity/'.$image_name));

        $str = public_path('storage/gambar-activity-wm/watermark-'.$image_name);
        $lines = wordwrap($str, 35, "\r\n", TRUE); // break line after 120 characters

        $img->text($lines, 120, 100, function($font) {
            $font->file(public_path('fonts/Montserrat-Medium.ttf'));
            $font->size(20);
            $font->color('#f4d442');
            // $font->color([255, 255, 255, 0.7]);
            $font->align('left');
            // $font->align('center');
            $font->valign('bottom');
            $font->angle(0);
        });

        $img->save(public_path('storage/gambar-activity-wm/watermark-'.$image_name));
        $filepath = public_path('storage/gambar-activity-wm/watermark-'.$image_name);

        return response()->download($filepath);
    }
}
