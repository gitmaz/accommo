<?php
namespace Api;

use Services\HttpService;
use Traits\SimpleCacheTrait;

/**
 * Class SuburbsController
 * @package Api
 */
class SuburbsController {

    use SimpleCacheTrait;

    /**
     * Returns all suburbs in a given state.
     * Note: if state is not found in query string, it will return NSW suburbs
     *
     * @param array $queryParams The query parameters.
     * @return string|array Returns a JSON-encoded string or an array containing suburb information.
     */
    public function index(array $queryParams): string|array {
        $cacheKey = 'suburbs';

        // Attempt to get cached data
        $cachedData = $this->getCachedData($cacheKey);
        if ($cachedData !== false) {
            // Return cached data if available
            return $cachedData;
        }

        // Access query parameters
        $state = $queryParams['state'] ?? 'NSW';

        //todo: move all urls to a config file
        $httpService = new HttpService("https://atlas.atdw-online.com.au/api/atlas/");
        $suburbs = $httpService->fetch("suburbs", "st=$state");

        // Extract useful info from result
        $suburbs = $suburbs["SuburbByState"]["Suburbs"]["suburb"];

        // Filter only useful fields
        $suburbs = array_map(function ($suburb) {
            return [
                'id' => $suburb['Name'],
                'postCode' => $suburb['PostCode'],
                'name' => $suburb['Name'],
                'namePlusPostcode' => !is_array($suburb['Name']) ? $suburb['Name'] . " " . $suburb['PostCode'] : null,
            ];
        }, $suburbs);

        // Remove records where 'Name' is an array
        $suburbs = array_filter($suburbs, function ($suburb) {
            return !is_array($suburb['name']);
        });

        $suburbs = array_values($suburbs);

        // Cache the data for a day
        $this->cacheData($cacheKey, $suburbs, 86400);

        return $suburbs;

    }
}
