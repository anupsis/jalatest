<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JalaApi;

class ShrimpPrice extends Controller
{
    //
    public function index($id)
    {
        $data = $this->detail_price($id);
        return view('shrimp_price.index', $data);
    }

    private function detail_price($id)
    {
        $client       = new \GuzzleHttp\Client();
        $response     = $client->request('GET', 'https://app.jala.tech/api/shrimp_prices/' . $id);
        $response     = json_decode($response->getBody()->getContents(), true);
        $detail_price = $response['data'];
        $data         = array(
            'regions'      => json_decode(JalaApi::province($detail_price['region_id'])),
            'species'      => json_decode(JalaApi::species($detail_price['species_id'])),
            'lists'        => json_decode(JalaApi::priceLists($detail_price['region_id'])),
            'detail_price' => json_decode(json_encode($detail_price)),
        );
        return $data;
    }

    public function rekomendasi($name)
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://app.jala.tech/api/regions?search=' . $name . '&scope=province');
        $response = json_decode($response->getBody()->getContents(), true);

        $data = array(
            'status' => false,
            'data'   => []
        );

        if (isset($response['data']) && count($response['data']) > 0) {
            $data = array(
                'status' => true,
                'data'   => json_decode($this->priceLists($response['data'][0]['province_id'])),
            );
        }

        return json_encode($data);

    }
}
