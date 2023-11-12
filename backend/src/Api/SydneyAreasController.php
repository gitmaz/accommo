<?php
namespace Api;

class SydneyAreasController extends AreasController
{

    public function index($queryStr, $outputAsArray=false){

        $areas = parent::index($queryStr, true);

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

        if($outputAsArray){
            return $sydneyAreas;
        }
        echo json_encode($sydneyAreas);
    }
}