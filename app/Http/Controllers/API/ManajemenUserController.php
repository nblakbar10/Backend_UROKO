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
        $user = User::find($user_id);
        if ($user_id == Auth::user()->id) {
            $pet = PetProfile::where('user_id', $user_id)->get()->count();
            $user['total_pet'] = $pet;

            $album = PetGallery::where('user_id', $user_id)->get()->count();
            $user['total_album'] = $album;
            $following = UserFollow::where('user_yg_difollow_id', Auth::user()->id)->get()->count(); 
            $follower = UserFollow::where('user_id', Auth::user()->id)->get()->count();//untuk nyari total follower, harus pake 'user_yg_difollow_id' 
            $user['total_follower'] = $follower;
            $user['total_following'] = $following;
            $data = [
                'message' => 'Success',
                'data' => $user
            ];  
            return response()->json($data, 200);
        } else {
            $pet = PetProfile::where('user_id', $user_id)->where('pet_status', 'PUBLIK')->get()->count();
            $user['total_pet'] = $pet;
            $data = [
                'message' => 'Success',
                'data' => $user
            ];  
            return response()->json($data, 200);
        }
        
    }

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
