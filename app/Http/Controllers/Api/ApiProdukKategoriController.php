<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategory;

class ApiProdukKategoriController extends Controller
{
    /**
     * Get all users from DB in tabular form
     * @return response json
     */
    public function getProdukKategoriTabular(Request $request) {
        // print_r('test');die();

    	$data = Kategory::orderBy('id', 'desc')->get();

    	return response()->json($data);
    }
    public function getOngkir(){
    	$curl = curl_init();

    	curl_setopt_array($curl, array(
    		CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_ENCODING => "",
    		CURLOPT_MAXREDIRS => 10,
    		CURLOPT_TIMEOUT => 30,
    		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    		CURLOPT_CUSTOMREQUEST => "GET",
    		CURLOPT_HTTPHEADER => array(
    			"key: 55e3e22492e652ac6b7f8034f3c7cf1a"
    		),
    	));

    	$response = curl_exec($curl);
    	$err = curl_error($curl);

    	curl_close($curl);

    	if ($err) {
    		echo "cURL Error #:" . $err;
    	} else {
    		echo $response;
    	}
    }

}
