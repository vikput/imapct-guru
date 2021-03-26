<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LaunchController extends Controller
{
    private $request;
    private $client;
    function __construct(Request $request, Client $client) {
        $this->request = $request;
        $this->client = $client;
    }

    function getLaunches($page, $pagesize){
    	try {

	    	$default_page = 1;
	    	if ($page < $default_page) {
	    		$page = $default_page;
	    	}

	    	$offset = ($page - 1) * $pagesize;
	    	$limit = $pagesize;

	    	$json_response = [];

			$response = $this->client->request('GET', 'https://api.spacexdata.com/v3/launches', ['query' => [
			    'offset' => $offset, 
			    'limit' => $limit,
			]]);

			$content = json_decode($response->getBody(), true);

	        $json_response['status'] = $response->getStatusCode();
	        $json_response['data'] = json_decode($response->getBody(), true);
    		
    	} catch (Exception $e) {
    		$json_response['status'] = $response->getStatusCode();
    		$json_response['message'] = $e->getMessage();
    	}
    	
        return response()->json($json_response);

    }


}
