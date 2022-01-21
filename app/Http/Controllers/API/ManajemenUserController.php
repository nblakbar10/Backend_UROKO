<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Merchant;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Auth;
use Illuminate\Support\Facades\Validator;

class ManajemenUserController extends Controller
{
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
