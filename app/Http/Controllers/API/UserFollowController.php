<?php

namespace App\Http\Controllers\API;

//use App\Follow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Merchant;
use App\Models\UserFollow;
use Auth;
use Illuminate\Support\Facades\Validator;


class UserFollowController extends Controller
{
    public function get_all_following(Request $request){
        $allfollower = UserFollow::where('user_id', Auth::user()->id)->get();
        if (!$allfollower) {
            $data = [
                'message' => 'anda tidak mengikuti siapapun'
            ];
            return response()->json($data, 404);
        }
        $detailallfollowingjoin = 
        UserFollow::leftjoin('users', 'users.id', 'user_follow.user_yg_difollow_id')
        ->select('user_follow.*','users.username')
        ->where('user_follow.user_id',Auth::user()->id)
        ->get();

        return response()->json([
            'status' => '200 OK',
            'message' =>'get all following success',
            'users username' => Auth::user()->username,
            'data' => $detailallfollowingjoin
        ]);
    }

    public function get_all_follower(Request $request){
        $allfollower = UserFollow::where('user_id', Auth::user()->id)->get();
        if (!$allfollower) {
            $data = [
                'message' => 'anda tidak memiliki pengikut'
            ];
            return response()->json($data, 404);
        }
        $detailallfollowerjoin = 
        UserFollow::leftjoin('users', 'users.id', 'user_follow.user_id')
        ->select('user_follow.*','users.username')
        ->where('user_follow.user_yg_difollow_id', Auth::user()->id)
        ->get();

        return response()->json([
            'status' => '200 OK',
            'message' =>'get all following success',
            'users username' => Auth::user()->username,
            'data' => $detailallfollowerjoin
        ]);
    }

    public function post_follow(Request $request, $id){ //ngasih id yg mau difollow
        $checkUser = UserFollow::select('user_yg_difollow_id')->where('user_yg_difollow_id', $id)->exists();
        if ($checkUser) {
            $data = [
                'message' => 'anda sudah mengikuti user ini'
            ];
            return response()->json($data, 404);
        }

        $follow_user = UserFollow::create([
            'user_id' => auth()->user()->id,
            'user_yg_difollow_id' => $id
            ]);

        $detailfollowuserjoin = 
        UserFollow::leftjoin('users', 'users.id', 'user_follow.user_yg_difollow_id')
        ->select('user_follow.*','users.username')
        ->where('user_follow.user_yg_difollow_id',$id) //bakal nampilin username yg difollow
        ->get();

        return response()->json([
            'status' => '200 OK',
            'message' =>'follow user success',
            'users username' => Auth::user()->username,
            'data' => $detailfollowuserjoin  
        ]);
    }


    public function post_unfollow(Request $request, $id){ //ngasih id yg mau diunfollow (id yg jadi Primary Key di table Follower)
        $follow_user = UserFollow::findOrFail($id);
        if($follow_user)
           $follow_user->delete(); 
        else
            return response()->json([
                'not followed any user'
            ]);

        $detailfollowuserjoin = 
        UserFollow::leftjoin('users', 'users.id', 'user_follow.user_yg_difollow_id')
        ->select('user_follow.*','users.username')
        ->where('user_follow.user_yg_difollow_id',$id) //bakal nampilin username yg diunfollow
        ->get();

        return response()->json([
            'status' => '200 OK',
            'message' =>'unfollow user success',
            'unfollowed user data' => $detailfollowuserjoin  //$follow_user
        ]);
    }
}
