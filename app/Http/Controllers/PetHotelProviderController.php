<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\PetHotelProvider;
use App\Models\Merchant;
use Yajra\Datatables\Datatables;

class PetHotelProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('role', 'User')->get();
        return view('Admin.Pet-Hotel-Provider.index', compact('user'));
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
        $pethotelprovider = PetHotelProvider::where('user_id', $request->username)->first();
        $user = User::where('id', $request->username)->first();
        $merchant = Merchant::where('user_id',$user->id)->first();
        if ($pethotelprovider == NULL) {
            // dd($request->username);
           
                $host = $request->getSchemeAndHttpHost();
                $pet_hotel_provider_image = $request->pet_hotel_provider_image;
                $fileName_petHotelProviderImage = time().'_'.$pet_hotel_provider_image->getClientOriginalName();
                $fileName_petHotelProviderImage2 = $host.'/storage/gambar-hotel/'.$fileName_petHotelProviderImage;
                $pet_hotel_provider_image->move(public_path('storage/gambar-hotel'), $fileName_petHotelProviderImage);
                

                $data = PetHotelProvider::create([
                    'user_id' => $user->id,
                    'merchant_id' => $merchant->id, //jika penyedianya dari user, maka ini dinullkan saja
                    'name' => $request->pet_hotel_provider_name,
                    'address' => $request->pet_hotel_provider_address,
                    'phone' => $request->pet_hotel_provider_phone,
                    'photo' => $fileName_petHotelProviderImage,
                    'description' => $request->pet_hotel_provider_description,
                ]);
    
                return redirect()->back()->with('success', 'Berhasil menambah hotel provider');
            
        } else {
            return redirect()->back()->with('error', 'Akun ini sudah memiliki hotel provider!');
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
        $pethotelprovider = PetHotelProvider::find($id);
        
        if ($pethotelprovider != NULL) {
            // dd($request->username);
                if ($request->pet_hotel_provider_image == NULL) {
                    $data = $pethotelprovider->update([ //jika penyedianya dari user, maka ini dinullkan saja
                        'name' => $request->pet_hotel_provider_name,
                        'address' => $request->pet_hotel_provider_address,
                        'phone' => $request->pet_hotel_provider_phone,
                        'description' => $request->pet_hotel_provider_description,
                    ]);
        
                    return redirect()->back()->with('success', 'Berhasil melakukan update hotel provider');
                } else {
                    $host = $request->getSchemeAndHttpHost();
                    $pet_hotel_provider_image = $request->pet_hotel_provider_image;
                    $fileName_petHotelProviderImage = time().'_'.$pet_hotel_provider_image->getClientOriginalName();
                    $fileName_petHotelProviderImage2 = $host.'/storage/gambar-hotel/'.$fileName_petHotelProviderImage;
                    $pet_hotel_provider_image->move(public_path('storage/gambar-hotel'), $fileName_petHotelProviderImage);
                    

                    $data = $pethotelprovider->update([
                        'name' => $request->pet_hotel_provider_name,
                        'address' => $request->pet_hotel_provider_address,
                        'phone' => $request->pet_hotel_provider_phone,
                        'photo' => $fileName_petHotelProviderImage,
                        'description' => $request->pet_hotel_provider_description,
                    ]);
    
                    return redirect()->back()->with('success', 'Berhasil melakukan update hotel provider');
                }
            
        } else {
            return redirect()->back()->with('error', 'Akun ini tidak memiliki hotel provider!');
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
        $provider = PetHotelProvider::find($id)->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus pet hotel provider');
    }

    public function get_pet_hotel_provider(Request $request)
    {
        $pethotelprovider = PetHotelProvider::leftjoin('users','users.id','pet_hotel_provider.user_id')
        ->leftjoin('merchant','merchant.id','pet_hotel_provider.merchant_id')
        ->select('pet_hotel_provider.*',
        'users.username',
        'merchant.merchant_name',);

        $datatables = Datatables::of($pethotelprovider);

        if ($request->get('search')['value']) {
            $datatables->filter(function ($query) {
                    $keyword = request()->get('search')['value'];
                    $query->where('name', 'like', "%" . $keyword . "%");

        });}

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('pet_hotel_provider.updated_at', $order);
        });
        return $datatables->addIndexColumn()
        ->escapeColumns([])
        ->addColumn('action','Admin.Pet-Hotel-Provider.action')
        ->addColumn('photo','Admin.Pet-Hotel-Provider.picture')
        ->toJson();
    }

    public function get_merchant_for_hotel_provider(Request $request)
    {
        $merchant = Merchant::where('user_id',$request->user_id)->first();
        if ($merchant) {
            $data = $merchant->merchant_name;
        } else {
            $data = NULL;
        }
        return response()->json([
            'data' => $data
        ]);
    }
}
