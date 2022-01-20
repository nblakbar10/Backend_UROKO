<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetActivity;
use App\Models\PetGroup;
use App\Models\PetProfile;
use App\Models\User;
use Auth;
use Response;
use App\Models\PetHotelProvider;
use App\Models\PetHotelProviderBookingSlots;
use App\Models\PetHotelProviderFee;
use App\Models\PetHotelProviderAmminities;
use App\Models\PetHotelProviderAmminitiesExtra;
use Illuminate\Support\Facades\Validator;

class PetHotelProviderController extends Controller
{
    public function pet_hotel_provider_index()
    {
        $pet_hotel_provider = PetHotelProvider::where('user_id', Auth::user()->id)->get();
        if ($pet_hotel_provider) {
            $feejoin = PetHotelProvider::leftjoin('pet_hotel_provider_fee','pet_hotel_provider_fee.pet_hotel_provider_id', 'pet_hotel_provider.id')
            ->where('user_id', auth()->user()->id)
            ->select('pet_hotel_provider.*', 'pet_hotel_provider_fee.id', 'pet_hotel_provider_fee.pet_hotel_provider_id','pet_hotel_provider_fee.pet_type', 'pet_hotel_provider_fee.pet_size', 
            'pet_hotel_provider_fee.slot_available', 'pet_hotel_provider_fee.price_per_day')
            ->get();

            foreach($pet_hotel_provider as $item){
                $data_pet_hotel_provider_fee = null;
                foreach($feejoin as $data){
                    if($item->id == $data->pet_hotel_provider_id){
                        $data_pet_hotel_provider_fee[] = [
                            "id" => $data->id,
                            "pet_hotel_provider_id" => $data->pet_hotel_provider_id,
                            "pet_type" => $data->pet_type,
                            "pet_size" => $data->pet_size,
                            "slot_available" => $data->slot_available,
                            "price_per_day" => $data->price_per_day
                        ];
                    }
                }
            
                $joinbaru[] = [
                    'id' => $item->id,
                    'user_id' => $item->user_id,
                    'merchant_id' => $item->merchant_id,
                    'name' => $item->name,
                    'address' => $item->address,
                    'phone' => $item->phone,
                    'photo' => $item->photo,
                    'description' => $item->description,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'data_pet_hotel_provider_fee' => $data_pet_hotel_provider_fee
                ];
            }
        }
        else{
            $pet_hotel_provider = "Anda belum memiliki pet hotel provider!";
        }

        

        $data = [
            'message' => 'Success',
            'data' => $joinbaru
        ];

        return response()->json($data, 200);
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

    public function pet_hotel_provider_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'description' => 'required',
            'photo' => 'mimes:jpeg,jpg,png|required|max:10000'
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $pet_hotel_provider = PetHotelProvider::where('user_id', Auth::user()->id)->first();
        if (!$pet_hotel_provider) {
            $host = $request->getSchemeAndHttpHost();

            $file_pet_hotel_provider_image = $request->photo;
            $fileName_pet_hotel_provider_image = $host.'/storage/gambar-pet_hotel_provider/'.time().'_'.$file_pet_hotel_provider_image->getClientOriginalName();
            $file_pet_hotel_provider_image->move(public_path('storage/gambar-pet_hotel_provider'), $fileName_pet_hotel_provider_image);

            $pet_hotel_provider = PetHotelProvider::create([
                'user_id' => Auth::user()->id,
                'merchant_id' => $request->merchant_id,
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'description' => $request->description,
                'photo' => $fileName_pet_hotel_provider_image,
            ]);
    
            $data = [
                'message' => 'Success',
                'data' =>$pet_hotel_provider
            ];
    
            if ($pet_hotel_provider) {
                return response()->json($data, 200);
            }
        } else {
            $data = [
                'message' => 'Failed',
                'data' => 'Anda sudah memiliki Pet Hotel Provider',
                'pet_hotel_provider' => $pet_hotel_provider
            ];
    
            if ($pet_hotel_provider) {
                return response()->json($data, 400);
            }
        }
    }

    public function pet_hotel_provider_update(Request $request)
    {
        
        $pet_hotel_provider = PetHotelProvider::where('user_id', Auth::user()->id)->first();

        if ($pet_hotel_provider == NULL) {
            $data = [
                'message' => 'Success',
                'data' => 'Anda tidak memiliki pet hotel provider'
            ];  
            return response()->json($data, 400);
        }

        $input = $request->all();

        if ($request->photo != NULL) {
            $host = $request->getSchemeAndHttpHost();

            $file_pet_hotel_provider_image = $request->photo;
            $fileName_pet_hotel_provider_image = $host.'/storage/gambar-pet_hotel_provider/'.time().'_'.$file_pet_hotel_provider_image->getClientOriginalName();
            $file_pet_hotel_provider_image->move(public_path('storage/gambar-pet_hotel_provider'), $fileName_pet_hotel_provider_image);

            
            $pet_hotel_provider->fill($input)->save();
            $pet_hotel_provider->update([
                'photo' => $fileName_pet_hotel_provider_image
            ]);

            $data = [
                'message' => 'Success',
                'data' => $pet_hotel_provider
            ];  
            return response()->json($data, 200);
        }
        
        $pet_hotel_provider->fill($input)->save();

        $data = [
            'message' => 'Success',
            'data' => $pet_hotel_provider
        ];  
        return response()->json($data, 200);
    }


    public function pet_hotel_provider_delete(Request $request)
    {
        $pet_hotel_provider = PetHotelProvider::where('user_id', Auth::user()->id)->first();
        if ($pet_hotel_provider == NULL) {
            $data = [
                'message' => 'Success',
                'data' => 'Anda tidak memiliki pet_hotel_provider'
            ];  
            return response()->json($data, 400);
        }
        $pet_hotel_provider->delete();

        $data = [
            'message' => 'Success',
            'data' => 'Berhasil menghapus pet_hotel_provider anda'
        ];  
        return response()->json($data, 200);
    }
    //bikin fungsi : pethotel_services_list_get, pethotel_services_request_post, pethotel_services_request_edit, 
    // pethotel_services_request_delete

    //dibikin logika untuk memilih dulu apakah mau menjual jasa pethotel atas nama pribadi atau merchant,
    //kalau merchant berarti ngambil id_merchant, kalau user berarti ngambil id_user


    //bikin lagi

    //function buat provider :

    //function buat client/consumer : 

    //controller : PetHotelProvider //buat provider, terus nanti ada function
    //controlelr : PetHotelOrder //buat consumer

    public function pet_hotel_provider_fee_post(Request $request, $pet_hotel_provider_id)
    {

        $validator = Validator::make($request->all(), [
            'pet_type' => 'required',
            'pet_size' => 'required',
            'slot_available' => 'required',
            'price_per_day' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $pet_hotel_provider_fee = PetHotelProviderFee::create([
            'user_id' => Auth::user()->id,
            'pet_hotel_provider_id' => $pet_hotel_provider_id,
            'pet_type' => $request->pet_type,
            'pet_size' => $request->pet_size,
            'slot_available' => $request->slot_available,
            'price_per_day' => $request->price_per_day,
        ]);

        $data = [
            'message' => 'Success',
            'data' => $pet_hotel_provider_fee
        ];
        return response()->json($data, 200);
    }



    public function pet_hotel_provider_fee_index()
    {
        $pet_hotel_provider_fee = PetHotelProviderFee::where('user_id', Auth::user()->id)->first();
        if (!$pet_hotel_provider_fee) {
            $pet_hotel_provider_fee = "Belum ada pet_hotel_provider_fee!";
        }
        
        $data = [
            'message' => 'Success',
            'data' => $pet_hotel_provider_fee
        ];

        return response()->json($data, 200);
    }



    public function pet_hotel_provider_fee_update(Request $request, $id)
    {
        
        $pet_hotel_provider_fee = PetHotelProviderFee::find($id);

        if (!$pet_hotel_provider_fee) {
            $data = [
                'message' => 'Success',
                'data' => 'Anda tidak memiliki pet hotel provider fee'
            ];  
            return response()->json($data, 400);
        }

        $input = $request->all();

        $pet_hotel_provider_fee->fill($input)->save();

        $data = [
            'message' => 'Edit Success',
            'data' => $pet_hotel_provider_fee
        ];  
        return response()->json($data, 200);
    }


    public function pet_hotel_provider_fee_delete(Request $request, $id)
    {
        $pet_hotel_provider_fee = PetHotelProviderFee::find($id);

        if (!$pet_hotel_provider_fee) {
            $data = [
                'message' => 'Success',
                'data' => 'Anda tidak memiliki pet_hotel_provider_fee'
            ];  
            return response()->json($data, 400);
        }
        $pet_hotel_provider_fee->delete();

        $data = [
            'message' => 'Success',
            'data' => 'Berhasil menghapus pet_hotel_provider_fee anda'
        ];  
        return response()->json($data, 200);
    }




    ////AMMINITIES

    public function pet_hotel_provider_amminities_post(Request $request, $pet_hotel_provider_id)
    {

        $validator = Validator::make($request->all(), [
            'food' => 'required',
            'basking' => 'required',
            'cleaning' => 'required',
            'bedding' => 'required',
            'grooming' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $pet_hotel_provider_amminities = PetHotelProviderAmminities::create([
            'user_id' => Auth::user()->id,
            'pet_hotel_provider_id' => $pet_hotel_provider_id,
            'food' => $request->food,
            'basking' => $request->basking,
            'cleaning' => $request->cleaning,
            'bedding' => $request->bedding,
            'grooming' => $request->grooming,
        ]);

        $data = [
            'message' => 'Success',
            'data' => $pet_hotel_provider_amminities
        ];
        return response()->json($data, 200);
    }

    // public function pet_hotel_provider_amminities_index()
    // {
    //     $pet_hotel_provider_amminities = PetHotelProviderAmminities::where('user_id', Auth::user()->id)->first();
    //     if (!$pet_hotel_provider_amminities) {
    //         $pet_hotel_provider_amminities = "Belum ada pet_hotel_provider_amminities!";
    //     }
        
    //     $data = [
    //         'message' => 'Success',
    //         'data' => $pet_hotel_provider_amminities
    //     ];

    //     return response()->json($data, 200);
    // }

    public function pet_hotel_provider_amminities_update(Request $request, $id)
    {
        
        $pet_hotel_provider_amminities = PetHotelProviderAmminities::find($id);

        if (!$pet_hotel_provider_amminities) {
            $data = [
                'message' => 'Success',
                'data' => 'Anda tidak memiliki pet hotel provider amminities'
            ];  
            return response()->json($data, 400);
        }

        $input = $request->all();

        $pet_hotel_provider_amminities->fill($input)->save();

        $data = [
            'message' => 'Edit Success',
            'data' => $pet_hotel_provider_amminities
        ];  
        return response()->json($data, 200);
    }


    public function pet_hotel_provider_amminities_delete(Request $request, $id)
    {
        $pet_hotel_provider_amminities = PetHotelProviderAmminities::find($id);

        if (!$pet_hotel_provider_amminities) {
            $data = [
                'message' => 'Success',
                'data' => 'Anda tidak memiliki pet_hotel_provider_amminities'
            ];  
            return response()->json($data, 400);
        }
        $pet_hotel_provider_amminities->delete();

        $data = [
            'message' => 'Success',
            'data' => 'Berhasil menghapus pet_hotel_provider_amminities anda'
        ];  
        return response()->json($data, 200);
    }



    ///AMMINITIES EXTRA

    public function pet_hotel_provider_amminities_extra_post(Request $request, $pet_hotel_provider_id)
    {

        $validator = Validator::make($request->all(), [
            'extra_amminities_name' => 'required',
            'extra_amminities_price_per_day' => 'required'
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        $pet_hotel_provider_amminities_extra = PetHotelProviderAmminitiesExtra::create([
            'user_id' => Auth::user()->id,
            'pet_hotel_provider_id' => $pet_hotel_provider_id,
            'extra_amminities_name' => $request->extra_amminities_name,
            'extra_amminities_price_per_day' => $request->extra_amminities_price_per_day,
        ]);

        $data = [
            'message' => 'Success',
            'data' => $pet_hotel_provider_amminities_extra
        ];
        return response()->json($data, 200);
    }

    // public function pet_hotel_provider_amminities_extra_index()
    // {
    //     $pet_hotel_provider_amminities = PetHotelProviderAmminitiesExtra::where('user_id', Auth::user()->id)->first();
    //     if (!$pet_hotel_provider_amminities) {
    //         $pet_hotel_provider_amminities = "Belum ada pet_hotel_provider_amminities!";
    //     }
        
    //     $data = [
    //         'message' => 'Success',
    //         'data' => $pet_hotel_provider_amminities
    //     ];

    //     return response()->json($data, 200);
    // }

    public function pet_hotel_provider_amminities_extra_update(Request $request, $id)
    {
        
        $pet_hotel_provider_amminities_extra = PetHotelProviderAmminitiesExtra::find($id);

        if (!$pet_hotel_provider_amminities_extra) {
            $data = [
                'message' => 'Success',
                'data' => 'Anda tidak memiliki pet hotel provider amminities extra'
            ];  
            return response()->json($data, 400);
        }

        $input = $request->all();

        $pet_hotel_provider_amminities_extra->fill($input)->save();

        $data = [
            'message' => 'Edit Success',
            'data' => $pet_hotel_provider_amminities_extra
        ];  
        return response()->json($data, 200);
    }


    public function pet_hotel_provider_amminities_extra_delete(Request $request, $id)
    {
        $pet_hotel_provider_amminities_extra = PetHotelProviderAmminitiesExtra::find($id);

        if (!$pet_hotel_provider_amminities_extra) {
            $data = [
                'message' => 'Success',
                'data' => 'Anda tidak memiliki pet_hotel_provider_amminities_extra'
            ];  
            return response()->json($data, 400);
        }
        $pet_hotel_provider_amminities_extra->delete();

        $data = [
            'message' => 'Success',
            'data' => 'Berhasil menghapus pet_hotel_provider_amminities_extra anda'
        ];  
        return response()->json($data, 200);
    }
}
