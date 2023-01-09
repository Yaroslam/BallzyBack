<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoesApiController extends Controller
{
    public function getAllShoes() {
        return Shoe::all();
    }

    public function getSingleShoesInfo(Request $request){
        $shoeData = [];
        $desc = "";

        $shoe = Shoe::where("shoe_id", $request['id'])->get()[0];

        foreach ($shoe->shoes_sizes as $size) {
            $desc = $desc . $size->size->size . " EU ";
        }

        $shoeData['img'] = $shoe['img'];
        $shoeData['shoes_name'] = $shoe['shoes_name'];
        $shoeData['price_euro'] = $shoe['price_euro'];
        $shoeData['shoe_id'] = $shoe['shoe_id'];
        $shoeData['brand'] = Brand::where("brand_id", $shoe['brand_id'])->get()[0]['brand_name'];
        $shoeData['description'] = $desc;

        return $shoeData;
    }



}
