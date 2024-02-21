<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;

class AddressController extends Controller
{
    public function getDeliveryAddress(Request $request) {
        if($request->ajax()){
            $data = $request->all();
            $address = DeliveryAddress::where('id', $data['addressid'])->first()->toArray();
            return response()->json(['address'=>$address]);
        }
    }
}
