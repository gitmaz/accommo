<?php
namespace Api;

use Services\HttpService;
use Traits\SimpleCacheTrait;

/**
 * Class LocationsController
 * @package Api
 */
class LocationsController {

    use SimpleCacheTrait;

    /**
     * Returns all locations (area abd suburbs) in a given state.
     * Note: if state is not found in query string, it will return NSW locations
     *
     * @param array $queryParams The query parameters.
     * @return string|array Returns a JSON-encoded string or an array containing suburb information.
     */
    public function index(array $queryParams): string|array {
        $cacheKey = 'locations';

        // Attempt to get cached data
        /*$cachedData = $this->getCachedData($cacheKey);
        if ($cachedData !== false) {
            // Return cached data if available
            return $cachedData;
        }*/

        // Access query parameters
        $state = $queryParams['state'] ?? 'NSW';

        //todo: move all urls to a config file
        $httpService = new HttpService("https://atlas.atdw-online.com.au/api/atlas/");
        $locations = $httpService->fetch("locations", "st=$state");

        $locations = $locations["Location"];

        // Cache the data for a day
        $this->cacheData($cacheKey, $locations, 86400);

        return $locations;

    }
}
