<?php
namespace Api;

use Services\HttpService;
use Traits\SimpleCacheTrait;

class AreasController{

    use SimpleCacheTrait;

    public function index($queryStr, $outputAsArray=false){

        $cacheKey = 'areas';

        // Attempt to get cached data
        /*$cachedData = $this->getCachedData($cacheKey);
        if ($cachedData !== false) {
            // Return cached data if available
            if ($outputAsArray) {
                return $cachedData;
            }

            echo json_encode($cachedData);
            return;
        }*/

        $httpService = new HttpService("https://atlas.atdw-online.com.au/api/atlas/");
        $result = $httpService->fetch("areas");

        $areas =$result["Area"] ?? [];

        // Extract only the 'AreaId' and 'Name' properties
        $areas = array_map(function ($area) {
            return [
                'id' => $area['Code'],
                'name' => $area['Name'],
            ];
        }, $areas);

        //base array results starting with zero index
        $areas = array_values($areas);

        // Cache the data for a day
        $this->cacheData($cacheKey, $areas, 86400);

        if($outputAsArray){
            return $areas;
        }
        echo json_encode($areas);
    }
}