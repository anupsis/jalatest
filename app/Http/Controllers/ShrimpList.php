<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Helpers\JalaApi;

class ShrimpList extends Controller
{
    //
    public function index()
    {
        $id            = Input::get('id', 34);
        $province_name = Input::get('province_name', 'DI YOGYAKARTA');

        $data = array(
            'provinces'         => JalaApi::provinces(),
            'regions'           => [],
            'sortings'          => [],
            'prices'            => [],
            'lists'             => json_decode(JalaApi::priceLists($id)),
            'location'          => json_decode(JalaApi::provinceToLocation($province_name)),
            'selected_province' => $id,
        );
        return view('shrimp_list.index', $data);
    }
}
