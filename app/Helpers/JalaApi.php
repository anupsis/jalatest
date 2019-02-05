<?php

namespace App\Helpers;

class JalaApi
{
    static function provinces()
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://app.jala.tech/api/provinces');
        $response = json_decode($response->getBody()->getContents());
        return $response->data;
    }

    static function priceLists($id)
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://app.jala.tech/api/shrimp_prices?search&with=creator,species,region&sort=size_50|size_50,asc&region_id=' . $id);
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
            $temp = array(
                'id'               => $res->id,
                'created'          => date('d-m-Y', strtotime($res->date)),
                'category'         => $res->species->name,
                'category_id'      => $res->species_id,
                'creator'          => $res->creator->name,
                'province_name'    => $res->region->province_name,
                'region_name'      => $res->region->regency_name,
                'region_full_name' => $res->region->full_name,
                'phone'            => '0812312312',
                'size'             => '50',
                'price'            => $res->size_50,
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

    static function provinceToLocation($province_name)
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $province_name . '&key=AIzaSyA38N74y_xGwSV0bI_36OIXDdH-corZO5A');
        $response = json_decode($response->getBody()->getContents(), true);

        $data = array();

        if ($response['status'] == "OK") {
            $data['lat'] = $response['results'][0]['geometry']['location']['lat'];
            $data['lng'] = $response['results'][0]['geometry']['location']['lng'];
        }

        return json_encode($data);
    }

    static function province($id)
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://app.jala.tech/api/regions/' . $id);
        $response = json_decode($response->getBody()->getContents(), true);
        return json_encode($response['data']);
    }

    static function species($id)
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://app.jala.tech/api/species/' . $id);
        $response = json_decode($response->getBody()->getContents(), true);
        return json_encode($response['data']);
    }
}