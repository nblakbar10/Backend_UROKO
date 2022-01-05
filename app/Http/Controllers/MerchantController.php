<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;
use App\Models\Merchant;
use App\Models\User;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('role','User')->get();
        return view('Admin.Merchant.index', compact('user'));
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
        $merchant = Merchant::where('user_id', $request->username)->first();

        if ($merchant == NULL) {
            if ($request->merchant_image == NULL) {
                $merchant = Merchant::create([
                    'user_id' => $request->username,
                    'merchant_name' => $request->merchant_name
                ]);
    
                return redirect()->back()->with('success', 'Berhasil menambah merchant');
            } else {
                $file_merchant_image = $request->merchant_image;
                $fileName_merchantImage = time().'_'.$file_merchant_image->getClientOriginalName();
                $file_merchant_image->move(public_path('storage/gambar-merchant'), $fileName_merchantImage);
    
                $user = User::where('id', $request->username)->first();
                $merchant = Merchant::create([
                    'user_id' => $request->username,
                    'user_username' => $user->username,
                    'merchant_name' => $request->merchant_name,
                    'merchant_image' => $fileName_merchantImage
                ]);
    
                return redirect()->back()->with('success', 'Berhasil menambah merchant');
            }
        } else {
            return redirect()->back()->with('error', 'Akun ini sudah memiliki merchant!');
        }
        
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
    public function edit(Request $request, $id)
    {
        
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
        $merchant = Merchant::where('id', $id)->first();
        // dd($request->merchant_image);
        if ($request->merchant_image == NULL) {
            $merchant->update([
                'merchant_name' => $request->merchant_name
            ]);

            return redirect()->back()->with('success', 'Berhasil melakukan update merchant');
        } else {
            $file_merchant_image = $request->merchant_image;
            $fileName_merchantImage = time().'_'.$file_merchant_image->getClientOriginalName();
            $file_merchant_image->move(public_path('storage/gambar-merchant'), $fileName_merchantImage);

            $merchant->update([
                'merchant_name' => $request->merchant_name,
                'merchant_image' => $fileName_merchantImage
            ]);

            return redirect()->back()->with('success', 'Berhasil melakukan update merchant');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $merchant = Merchant::where('id', $id)->first();
        $merchant->delete();

        return redirect()->back()->with('success', 'Berhasil melakukan hapus merchant');
    }

    public function get_merchant(Request $request)
    {
        $merchant = Merchant::leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'merchant.user_id');
        })->select('merchant.*', 'users.username');

        $datatables = Datatables::of($merchant);

        if ($request->get('search')['value']) {
            $datatables->filter(function ($query) {
                    $keyword = request()->get('search')['value'];
                    $query->where('merchant_name', 'like', "%" . $keyword . "%");

        });}

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('merchant.updated_at', $order);
        });
        return $datatables->addIndexColumn()
        ->addColumn('action','Admin.Merchant.action')
        ->toJson();
    }
}
