<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShrimpPrice extends Controller
{
    //
    public function index($id)
    {
        $data = $this->detail_price($id);
        return view('shrimp_price.index', $data);
    }

    public function detail_price($id)
    {
        $client       = new \GuzzleHttp\Client();
        $response     = $client->request('GET', 'https://app.jala.tech/api/shrimp_prices/' . $id);
        $response     = json_decode($response->getBody()->getContents(), true);
        $detail_price = $response['data'];
        $data         = array(
            'regions'      => json_decode($this->province($detail_price['region_id'])),
            'species'      => json_decode($this->species($detail_price['species_id'])),
            'lists'        => json_decode($this->priceLists($detail_price['region_id'])),
            'detail_price' => json_decode(json_encode($detail_price)),
        );
        return $data;
    }

    public function province($id)
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://app.jala.tech/api/regions/' . $id);
        $response = json_decode($response->getBody()->getContents(), true);
        return json_encode($response['data']);
    }

    private function species($id)
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://app.jala.tech/api/species/' . $id);
        $response = json_decode($response->getBody()->getContents(), true);
        return json_encode($response['data']);
    }

    private function priceLists($id)
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://app.jala.tech/api/shrimp_prices?search&with=creator,species,region&sort=size_500|size_50,asc&region_id=' . $id);
        $response = json_decode($response->getBody()->getContents());

        /* format
        array(
        'id'=>'',
        'date'=>'',
        'creator'=>'',
        'category'=>'',
        'category_id'=>'',
        'size'=>'',
        'price'=>'',
        'province_name'=>'',
        'region_name'=>'',
        'contact'=>'',
        'phone'=>'',
        );
        end */

        $data    = array();
        $temp    = array();
        $regions = array();
        foreach ($response->data as $res) {
        	$reg_name = ($res->region->regency_name==null?'':$res->region->regency_name);
            $temp = array(
                'id'               => $res->id,
                'created'          => date('d-m-Y', strtotime($res->date)),
                'category'         => $res->species->name,
                'category_id'      => $res->species_id,
                'creator'          => $res->creator->name,
                'province_name'    => $res->region->province_name,
                'region_name'      => $reg_name,
                'region_full_name' => $res->region->full_name,
                'phone'            => '0812312312',
                'size'             => '50',
                'price'            => number_format($res->size_50, 0, ',', '.'),
            );
            $data[] = $temp;
            $name   = "";

            if ($res->region->full_name != null) {
                $name = $res->region->full_name;
            } else {
                $name = $res->region->province_name;
            }

            $index = array_search($name, array_column($regions, 'name'));

            if ($index !== false) {
                $index                       = (int) $index;
                $regions[$index]['prices'][] = $res->size_50;
                $regions[$index]['average']  = array_sum($regions[$index]['prices']) / count($regions[$index]['prices']);
            } else {
                $regions[] = array(
                    'name'    => $name,
                    'prices'  => array($res->size_50),
                    'average' => $res->size_50,
                );
            }

        }

        return json_encode(array("regions" => $regions, "price_lists" => $data));
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
