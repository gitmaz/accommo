<?php

namespace Api;

use Services\HttpService;
use Traits\SimpleCacheTrait;

/**
 * Class SuburbsController
 * @package Api
 */
class SydneyAreasController extends AreasController
{
    use SimpleCacheTrait;

    /**
     * Returns all suburbs in a given state.
     *
     * @param array $queryParams The query parameters.
     * @return array
     */
    public function index(array $queryParams): array
    {

        $areas = parent::index($queryParams);

        //only focus on Sydney areas as per requirements:
        /* I am referring:
           "Build a single page application that uses data provided from the
           [ATDW Atlas API](https://developer.atdw.com.au/ATDWO-api.html) to list
            accommodation options in Sydney."
        */
        // Filter $areas where $area->Name contains "Sydney"
        $sydneyAreas = array_filter($areas, function ($area) {
            return stripos($area['name'], 'Sydney') !== false;
        });


        //base array results starting with zero index
        $sydneyAreas = array_values($sydneyAreas);

        return $sydneyAreas;

    }
}