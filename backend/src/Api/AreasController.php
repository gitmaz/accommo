<?php

namespace Api;

use Services\HttpService;
use Traits\SimpleCacheTrait;

/**
 * Class AreasController
 * @package Api
 */
class AreasController
{

    use SimpleCacheTrait;

    /**
     * Fetch areas and optionally output as an array.
     *
     * @param array $queryParams The query parameters.
     * @return array|void
     */
    public function index(array $queryParams) :array|null
    {

        $cacheKey = 'areas';

        // Attempt to get cached data
        $cachedData = $this->getCachedData($cacheKey);
        if ($cachedData && $cachedData !== false) {
            // Return cached data if available
            return $cachedData;
        }

        //todo: move all urls to a config file
        $httpService = new HttpService("https://atlas.atdw-online.com.au/api/atlas/");
        $result = $httpService->fetch("areas");

        $areas = $result["Area"] ?? [];

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

        return $areas;
    }
}