<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Merchant;
use App\Models\PetProfile;
use App\Models\PetGallery;
use App\Models\UserFollow;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Auth;
use Illuminate\Support\Facades\Validator;

class ManajemenUserController extends Controller
{
    public function get_detail_user($user_id)
    {
        $petcount = PetProfile::where('user_id', $user_id)->get()->count();
        $albumcount = PetGallery::where('user_id', $user_id)->get()->count();
        $followercount = UserFollow::where('user_yg_difollow_id', $user_id)->get()->count(); 
        $followingcount = UserFollow::where('user_id', $user_id)->get()->count();
        
        $detailallfollowingjoin = 
        UserFollow::leftjoin('users', 'users.id', 'user_id')
        ->select('user_follow.*','users.username', 'users.picture')
        ->where('user_follow.user_id', $user_id)
        ->get();

        $detailallfollowerjoin = 
        UserFollow::leftjoin('users', 'users.id', 'user_id')
        ->select('user_follow.*','users.username', 'users.picture')
        ->where('user_follow.user_yg_difollow_id', $user_id)
        ->get();


        $userget = User::where('id', $user_id)->get(); //->count() nanti ditaro di joinbaru aja

        $userjoin = User::leftjoin('pet_profile', 'pet_profile.id', 'pet_profile.user_id') //untuk fetch data pet
        ->leftjoin('pet_gallery', 'pet_gallery.user_id', 'pet_profile.album_id') //untuk fetch data album
        // ::leftjoin('users', 'users.id', 'pet_profile.user_id') //untuk fetch data user
        // ->leftjoin('user_follow', 'user_follow.user_id', 'user_follow.user_yg_difollow_id', 'users.id') //untuk fetch data follower
        
        // ->where('users.id', $user_id)
        ->select('users.*', 
        'pet_profile.id', 
        'pet_profile.pet_name', 
        'pet_profile.pet_picture', 
        'pet_profile.pet_species',

        'pet_profile.album_id', 
        'pet_gallery.album_name', 
        'pet_gallery.album_name', 
        'pet_gallery.album_picture',)
        // 'user_follow.user_yg_difollow_id', 'users.id', 'users.fullname', 'users.picture')
        ->get();


        foreach($userget as $item){
            $data_pet = PetProfile::where('user_id', $item->id)->get();
            $array_data_pet[] = $data_pet;
            $data_pet_album = PetGallery::where('user_id', $item->id)->get();
            $array_data_pet_album[] = $data_pet_album;

            
            $joinbaru[] = [
                'id' => $item->id,
                'fullname' => $item->fullname,
                'username' => $item->username,
                'email' => $item->email,
                'phone_number' => $item->phone_number,
                'merchant_status' => $item->merchant_status,
                'picture' => $item->picture,
                'birthdate' => $item->birthdate,
                'address' => $item->address,
                'role' => $item->role,
                'total_pet' => $petcount,
                'data_pet' => $array_data_pet,
                'total_pet_album' => $albumcount,
                'data_pet_album' => $array_data_pet_album,
                'total_follower' => $followercount,
                'data_follower' => $detailallfollowerjoin,
                'total_following' => $followingcount,
                'data_following' => $detailallfollowingjoin
            ];
        }

        return response()->json([
            'status' => '200 OK',
            "message" => "Success",
            "data" => $joinbaru
        ]);

    }

    // public function get_detail_user($user_id)
    // {
    //     $user = User::find($user_id);
    //     if ($user_id == Auth::user()->id) {
    //         $pet = PetProfile::where('user_id', $user_id)->get()->count();
    //         $user['total_pet'] = $pet;

    //         $album = PetGallery::where('user_id', $user_id)->get()->count();
    //         $following = UserFollow::where('user_yg_difollow_id', Auth::user()->id)->get()->count(); 
    //         $follower = UserFollow::where('user_id', Auth::user()->id)->get()->count();//untuk nyari total follower, harus pake 'user_yg_difollow_id' 
    //         $user['total_album'] = $album;
    //         $user['total_follower'] = $follower;
    //         $user['total_following'] = $following;
    //         $data = [
    //             'message' => 'Success',
    //             'data' => $user
    //         ];  
    //         return response()->json($data, 200);
    //     } else {
    //         $pet = PetProfile::where('user_id', $user_id)->where('pet_status', 'PUBLIK')->get()->count();
    //         $user['total_pet'] = $pet;
    //         $data = [
    //             'message' => 'Success',
    //             'data' => $user
    //         ];  
    //         return response()->json($data, 200);
    //     }
    // }

    // foreach($userget as $item){
    //     $data_pet = null;
    //     $data_pet_album = null;
    //     // $data_follower = null;
    //     // $data_following = null;
    //     foreach($userjoin as $data){
    //         if($item->id == $data->id){
    //             $data_pet[] = [
    //                 "pet_id" => $data->id,
    //                 "pet_name" => $data->pet_name,
    //                 "pet_picture" => $data->pet_picture,
    //                 "pet_species" => $data->pet_species
    //             ];
    //             $data_pet_album[] = [
    //                 "album_id" => $data->album_id,
    //                 "album_name" => $data->album_name,
    //                 "album_picture" => $data->album_picture
    //             ];
    //             // $data_follower[] = [
    //             //     "user_id" => $data->user_id,
    //             //     "username" => $data->username,
    //             //     "picture" => $data->picture
    //             // ];
    //             // $data_following[] = [
    //             //     "user_id" => $data->user_id,
    //             //     "username" => $data->username,
    //             //     "picture" => $data->picture
    //             // ];
    //         }
    //     }

    public function update_user_profile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $input = $request->all();

        if ($request->picture != NULL) {
            $host = $request->getSchemeAndHttpHost();
            $file_picture = $request->picture;
            $fileName_picture = time().'_'.$file_picture->getClientOriginalName();
            $fileName_picture2 = $host.'/storage/gambar-user/'.$fileName_picture;
            $file_picture->move(public_path('storage/gambar-user'), $fileName_picture);

            
            $user->fill($input)->save();
            $user->update([
                'picture' => $fileName_picture,
                'picture2' => $fileName_picture2
            ]);

            $data = [
                'message' => 'Success',
                'data' => $user
            ];  
            return response()->json($data, 200);
        }
        
        $user->fill($input)->save();

        $data = [
            'message' => 'Success',
            'data' => $user
        ];  
        return response()->json($data, 200);
    }

    public function delete_user_profile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->delete();

        $data = [
            'message' => 'Success',
            'data' => 'Berhasil menghapus akun'
        ];  
        return response()->json($data, 200);
    }
}