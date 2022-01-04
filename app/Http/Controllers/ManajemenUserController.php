<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Merchant;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {    
            return redirect()->back()->withErrors($validator->errors());
        }
        // $request->validate([
        //     'username' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'User'
        ]);

        return redirect()->back()->with('success', 'Berhasil menambah user');
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
        $user = User::where('id', $id)->first();

        if ($request->picture == NULL) {
            $user->update([
                'fullname' => $request->fullname,
                'phone_number' => $request->phone_number,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
            ]);
        } else {
            $file_user_image = $request->picture;
            $fileName_userImage = time().'_'.$file_user_image->getClientOriginalName();
            $file_user_image->move(public_path('storage/gambar-user'), $fileName_userImage);

            $user->update([
                'fullname' => $request->fullname,
                'phone_number' => $request->phone_number,
                'picture' => $fileName_userImage,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
            ]);
        }
        

        return redirect()->back()->with('success', 'Berhasil melakukan update user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        
        $merchant = Merchant::where('user_id', $id)->first();
        if ($merchant != NULL) {
            $merchant->delete();
        }

        return redirect()->back()->with('success', "Berhasil menghapus user");

    }

    public function get_user(Request $request)
    {
        $user = User::where('role','User')->leftJoin('merchant', function ($join) {
            $join->on('merchant.user_id', '=', 'users.id');
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
        ->escapeColumns([])
        ->addColumn('action','Admin.User.action')
        ->addColumn('picture','Admin.User.picture')
        ->toJson();
    }
}
