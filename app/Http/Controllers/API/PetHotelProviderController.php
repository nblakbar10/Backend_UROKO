<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetActivity;
use App\Models\PetGroup;
use App\Models\PetProfile;
use Auth;
use App\Models\PetHotelProvider;
use App\Models\PetHotelProviderBookingSlots;
//use App\Models\PetHotelExtraAmminities;
use Illuminate\Support\Facades\Validator;

class PetHotelProviderController extends Controller
{
    //bikin fungsi : pethotel_services_list_get, pethotel_services_request_post, pethotel_services_request_edit, 
    // pethotel_services_request_delete

    //dibikin logika untuk memilih dulu apakah mau menjual jasa pethotel atas nama pribadi atau merchant,
    //kalau merchant berarti ngambil id_merchant, kalau user berarti ngambil id_user


    //bikin lagi

    //function buat provider :

    //function buat client/consumer : 

    //controller : PetHotelProvider //buat provider, terus nanti ada function
    //controlelr : PetHotelOrder //buat consumer
}
