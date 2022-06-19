<?php

namespace App\Http\Controllers\API;
use App\Models\AuctionOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use App\Models\User;
use App\Models\PetProfile;
use App\Models\Merchant;
use App\Models\AuctionItem;
use Illuminate\Support\Facades\Validator;

class AuctionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function auctionorder_post(Request $request, $id)
    {
        $auctionitem = AuctionItem::findOrFail($id);
        if (!$auctionitem) {
            $data = [
                'message' => 'auction item not found'
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            // 'qty' => 'required',
            'bid_order_set' => 'required',
            'bid_order_notes' => 'required',
            'shipping_id' => 'required',
            'payments_option_id' => 'required',
            // 'grand_total_order' => 


        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 400);
        }

        ////$namamerchant = Merchant::find($id);
        $auctprice = AuctionItem::find($id)->auction_item_price;

        $totalorder = $auctprice; //+ 4500;
        ////$payms = PaymentsOption::find($id);
        ////$ships = Shipping::find($id);

        $auctionorder = AuctionOrder::create([
            'user_id' => Auth::user()->id,
            ////'username' => Auth::user()->username,
            ////'phone_number' => Auth::user()->phone_number,
            ////'address' => Auth::user()->address,
            'auction_item_id' => $id,
            'merchant_id' => $auctionitem->merchant_id,    //$namamerchant->merchant_name,
            'pet_id' => $auctionitem->pet_id,
            'shipping_id' => $request->shipping_id,
            'bid_order_set' => $request->bid_order_set,
            'bid_order_notes' =>$request->bid_order_notes,
            ////'shipping_type' => $ships->shipping_type,
            'payments_option_id' => $request->payments_option_id,
            ////'payments_option' => $payms->payment_type,
            'grand_total_order' => $totalorder,
            // 'pet_id' => $id,
            // 'qty' => $request->qty,
            // 'description' => $request->description,
            // 'merchant_id' => $request->merchant_id,
            'bid_order_status' => "BELUM DIKONFIRMASI"
            // 'user_address' => $alamat->address,
            // 'adoption_item_price' => $request->adoption_item_price,
        ]);

        $auctionorderjoin = AuctionOrder::leftjoin('users','users.id', 'auction_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'auction_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'auction_order.merchant_id')
        ->select('auction_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name', 'merchant.merchant_image')
        ->where('auction_order.id',$auctionorder->id)
        ->get();
        // dd($auctionorderjoin);

        $data = [
            'message' => 'Success',
            'data' => $auctionorderjoin
        ];     
        return response()->json($data, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function show(Auction $auction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        //
    }


    public function auctionorder_getdetail(Request $request, $id)
    {
        // $auctionorder = auctionOrder::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $auctionorder = AuctionOrder::findOrFail($id);
        if (!$auctionorder) {
            $data = [
                'message' => 'auction order not found'
            ];
            return response()->json($data, 404);
        }

        // untuk nampilin data count petalbum, petactivity, followers&following
        // $petcount = PetProfile::where('user_id', $user_id)->get()->count();
        
        // $albumcount = PetGallery::where('user_id', $user_id)->get()->count();
        // $followercount = UserFollow::where('user_yg_difollow_id', $user_id)->get()->count(); 
        // $followingcount = UserFollow::where('user_id', $user_id)->get()->count();

        // $detailallpetalbumjoin = 
        // UserFollow::leftjoin('users', 'users.id', 'user_id')
        // ->select('user_follow.*','users.username', 'users.picture')
        // ->where('user_follow.user_id', $user_id)
        // ->get();

        // $detailallpetactivityjoin = 
        // UserFollow::leftjoin('users', 'users.id', 'user_id')
        // ->select('user_follow.*','users.username', 'users.picture')
        // ->where('user_follow.user_id', $user_id)
        // ->get();

        // $detailallfollowingjoin = 
        // UserFollow::leftjoin('users', 'users.id', 'user_id')
        // ->select('user_follow.*','users.username', 'users.picture')
        // ->where('user_follow.user_id', $user_id)
        // ->get();

        // $detailallfollowerjoin = 
        // UserFollow::leftjoin('users', 'users.id', 'user_id')
        // ->select('user_follow.*','users.username', 'users.picture')
        // ->where('user_follow.user_yg_difollow_id', $user_id)
        // ->get();

        // $auctionorderget = AuctionOrder::where('id', $id)->get();

        $auctionorderjoin = AuctionOrder::leftjoin('users','users.id', 'auction_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'auction_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'auction_order.merchant_id')
        // ->leftjoin('pet_gallery', 'pet_gallery.id', 'pet_profile.album_id') //untuk masukin data petactivity
        ->select('auction_order.*',
        'users.username', 
        'users.phone_number', 
        'users.address', 

        'pet_profile.pet_picture', 
        'pet_profile.pet_name', 
        'pet_profile.pet_age', 
        'pet_profile.pet_species', 
        'pet_profile.pet_breed', 
        'pet_profile.pet_gender', 
        'pet_profile.pet_size', 
        'pet_profile.pet_weight',

        'merchant.merchant_name', 
        'merchant.merchant_image',)
        ->where('auction_order.id', $id)
        // ->where('auction_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        foreach ($auctionorderjoin as $key => $value){
            $arr['pet_activity_id'] = $value->id;
            $arr['pet_activity_detail'] = $value->pet_activity_detail;
            $arr['pet_activity_image'] = $value->pet_activity_image;
            $arr['pet_activity_image2'] = $value->pet_activity_image2;

            $arr_result[] = $arr;
        }


        // return response()->json($auctionorderjoin, 200);
        return response()->json([
            'message' => 'Success',
            'data' => $auctionorderjoin
        ], 200);
    }

//     foreach($userget as $item){
//         $data_pet = PetProfile::where('user_id', $item->id)->get();
//         $array_data_pet[] = $data_pet;
//         $data_pet_album = PetGallery::where('user_id', $item->id)->get();
//         $array_data_pet_album[] = $data_pet_album;

        
//         $joinbaru[] = [
//             'id' => $item->id,
//             'fullname' => $item->fullname,
//             'username' => $item->username,
//             'email' => $item->email,
//             'phone_number' => $item->phone_number,
//             'merchant_status' => $item->merchant_status,
//             'picture' => $item->picture,
//             'birthdate' => $item->birthdate,
//             'address' => $item->address,
//             'role' => $item->role,
//             'total_pet' => $petcount,
//             'data_pet' => $array_data_pet,
//             'total_pet_album' => $albumcount,
//             'data_pet_album' => $array_data_pet_album,
//             'total_follower' => $followercount,
//             'data_follower' => $detailallfollowerjoin,
//             'total_following' => $followingcount,
//             'data_following' => $detailallfollowingjoin
//         ];
//     }

//     return response()->json([
//         'status' => '200 OK',
//         "message" => "Success",
//         "data" => $joinbaru
//     ]);

// }




    
    public function auctionorder_getall(Request $request)
    {

        $auctionorder = AuctionOrder::where('user_id', Auth::user()->id)->get();
        // $adoptionorder = AdoptionOrder::where('user_id', Auth::user()->id)->where('id', $id)->first();
        // $adoptionorder = AdoptionOrder::findOrFail($id);
        if (!$auctionorder) {
            $data = [
                'message' => 'auction order not found'
            ];
            return response()->json($data, 404);
        }

        $auctionorderjoin = AuctionOrder::leftjoin('users','users.id', 'auction_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'auction_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'auction_order.merchant_id')
        ->select('auction_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name', 'merchant.merchant_image')
        ->where('auction_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json($auctionorderjoin, 200);
    }

    public function auctionorder_cancel(Request $request, $id)
    {
        $auctionorder = auctionOrder::findOrFail($id);
        if (!$auctionorder) {
            $data = [
                'message' => 'auction order not found'
            ];
            return response()->json($data, 404);
        }

        $auctionorder->update(['bid_order_status' => 'CANCELLED']);

        $auctionorderjoin = AuctionOrder::leftjoin('users','users.id', 'auction_order.user_id')
        ->leftjoin('pet_profile','pet_profile.id', 'auction_order.pet_id')
        ->leftjoin('merchant','merchant.id', 'auction_order.merchant_id')
        ->select('auction_order.*','users.username', 'users.phone_number', 'users.address', 
        'pet_profile.pet_picture', 'pet_profile.pet_name', 'pet_profile.pet_age', 'pet_profile.pet_species', 
        'pet_profile.pet_breed', 'pet_profile.pet_gender', 'pet_profile.pet_size', 'pet_profile.pet_weight',
        'merchant.merchant_name', 'merchant.merchant_image')
        ->where('auction_order.id', $id)
        // ->where('auction_order.user_id', Auth::user()->id) //ini buat get semua ordernya
        ->get();

        return response()->json([
            'status' => 200,
            'message' =>'Cancel auction order success',
            'data' => $auctionorderjoin
        ]);
    }
}




// $rencanaliburanjoin = RencanaLiburan::leftjoin('ajakteman_rencana_liburan', 'ajakteman_rencana_liburan.rencana_liburan_id', 'rencana_liburan.id')
//     ->leftjoin('users', 'users.id', 'ajakteman_rencana_liburan.id_penerima_ajakan')
//     ->leftjoin('destinasi_rencana_liburan', 'destinasi_rencana_liburan.rencana_liburan_id', 'rencana_liburan.id')
//     ->leftjoin('tempat_wisata', 'tempat_wisata.id', 'rencana_liburan.id')
//     ->select('rencana_liburan.*', 'ajakteman_rencana_liburan.id_penerima_ajakan', 'ajakteman_rencana_liburan.status_ajakan',
//     'users.username', 
//     'destinasi_rencana_liburan.tempat_wisata_id', 'destinasi_rencana_liburan.tanggal_rencana_liburan', 'destinasi_rencana_liburan.rencana_durasi_liburan',
//     'tempat_wisata.nama_wisata', 'tempat_wisata.alamat_wisata', 'tempat_wisata.foto') 
//     ->get();



// $ajaktemanrencanaliburanjoin = RencanaLiburan::leftjoin('ajakteman_rencana_liburan', 'ajakteman_rencana_liburan.rencana_liburan_id', 'rencana_liburan.id')
//     ->select('rencana_liburan.*', 'ajakteman_rencana_liburan.id_penerima_ajakan', 'ajakteman_rencana_liburan.status_ajakan')
//     ->get();


// $usernamejoin = RencanaLiburan::leftjoin('users', 'users.id', 'ajakteman_rencana_liburan.id_penerima_ajakan')
//     ->select('users.username')
//     ->get();

// $destinasirencanaliburanjoin = RencanaLiburan::leftjoin('destinasi_rencana_liburan', 'destinasi_rencana_liburan.rencana_liburan_id', 'rencana_liburan.id')
//     ->select('destinasi_rencana_liburan.tempat_wisata_id', 'destinasi_rencana_liburan.tanggal_rencana_liburan', 'destinasi_rencana_liburan.rencana_durasi_liburan')
//     ->get();


// $namawisatajoin = RencanaLiburan::leftjoin('tempat_wisata', 'tempat_wisata.id', 'rencana_liburan.id')
//     ->select('tempat_wisata.nama_wisata', 'tempat_wisata.alamat_wisata', 'tempat_wisata.foto')
//     ->get();