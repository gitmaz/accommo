<?php
namespace Api;

use Services\HttpService;
use Traits\SimpleCacheTrait;

class SuburbsController{

    use SimpleCacheTrait;

    /**
     * returns all suburbs in a given state (identified by state=<somestate> in querystring defaulted by NSW)
     */
    public function index($queryParams){

        $cacheKey = 'suburbs';

        // Attempt to get cached data
        /*$cachedData = $this->getCachedData($cacheKey);
        if ($cachedData !== false) {
            // Return cached data if available
            echo json_encode($cachedData);
            return;
        }*/

        // Access query parameters
        $state = $queryParams['state'] ?? 'NSW';

        $httpService = new HttpService("https://atlas.atdw-online.com.au/api/atlas/");
        $suburbs = $httpService->fetch("suburbs","st=$state");

        //extract useful info from result
        $suburbs=$suburbs["SuburbByState"]["Suburbs"]["suburb"];

        //filter only useful fields
        $suburbs = array_map(function ($suburb) {
            return [
                'id' => $suburb['Name'],
                'postCode' => $suburb['PostCode'],
                'name' =>  $suburb['Name'],
                'namePlusPostcode' => !is_array($suburb['Name']) ? $suburb['Name']." ".$suburb['PostCode'] : null
            ];
        }, $suburbs);

        // Remove records where 'Name' is an array
        $suburbs = array_filter($suburbs, function ($suburb) {
            return !is_array($suburb['name']);
        });

        $suburbs = array_values($suburbs);

        // Cache the data for a day
        $this->cacheData($cacheKey, $suburbs, 86400);


        echo json_encode($suburbs);
    }

}