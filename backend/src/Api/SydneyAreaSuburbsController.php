<?php
namespace Api;

use Services\HttpService;
use Traits\SimpleCacheTrait;

/**
 * Class SydneyAreaSuburbsController
 * @package Api
 */
class SydneyAreaSuburbsController  {

    use SimpleCacheTrait;

    /**
     * Returns all locations (area abd suburbs) in a given state.
     * Note: if state is not found in query string, it will return NSW locations
     *
     * @param array $queryParams The query parameters.
     * @return string|array Returns a JSON-encoded string or an array containing suburb information.
     */
    public function index(array $queryParams): string|array {

        $locationController = new LocationsController();
        $locations= $locationController->index($queryParams);

        $areaCode = $queryParams["area"] ?? null;

        if($areaCode === null){
            return (["status"=>"failure","message"=>"please supply area code in query string for ex. area=SCY"]);
        }

        $cacheKey = "sydney-area-$areaCode-suburbs";

        // Attempt to get cached data
        $cachedData = $this->getCachedData($cacheKey);
        if ($cachedData && $cachedData !== false) {
            // Return cached data if available
            return $cachedData;
        }

        // only keep locations whose area code is as given
        $locations = array_filter($locations, function ($location) use ($areaCode){
            return ($location['Code'] === $areaCode);
        });


        $location = array_values($locations);
        $suburbs=$location[0]["Suburbs"]["suburb"];

        // Filter only useful fields
        $suburbs = array_map(function ($suburb) {
            return [
                'id' => $suburb['Name'],
                'postCode' => $suburb['PostCode'],
                'name' => $suburb['Name'],
                'namePlusPostcode' => !is_array($suburb['Name']) ? $suburb['Name'] . " " . $suburb['PostCode'] : null,
            ];
        }, $suburbs);

        $suburbs = array_values($suburbs);

        // Cache the data for a day
        $this->cacheData($cacheKey, $suburbs, 86400);

        return $suburbs;

    }
}
