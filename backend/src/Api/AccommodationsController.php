<?php
namespace Api;

use Services\HttpService;

// sample usage:
// http://127.0.0.1:8000/api/accommodations?area=SCY
// http://127.0.0.1:8000/api/accommodations?area=SCY
class AccommodationsController{

    public function index($queryParams){

        $area = $queryParams['area'] ?? null;
        $suburb = $queryParams['suburb'] ?? null;

        if( $area === null && $suburb === null ){
           echo "at least one filter (area or suburb) should be included ib query string ex. area=SCY or suburb=Barangaroo";
        }

        $httpService = new HttpService("https://atlas.atdw-online.com.au/api/atlas/");

        $areaQueryStr= $area ? "ar=$area" : "";
        $suburbQueryStr= $suburb ? "ct=$suburb" : "";
        $queryStr= $areaQueryStr ? $areaQueryStr.($suburbQueryStr? "&$suburbQueryStr":"") : $suburbQueryStr;


        $accommodations = $httpService->fetch("products","cats=ACCOMM&rg=GSY&$queryStr");
     /*   echo json_encode($accommodations);
        die();*/

        if($accommodations["number_of_results"] == 1) {
            $accommodations = $accommodations["products"]["product_record"] ?? [];

            //prepare to handle one and many results uniform (in following array_map)
            $accommodations = [$accommodations];
        }else{
            $accommodations = $accommodations["products"]["product_record"] ?? [];
        }


        //filter only useful fields
        $accommodations = array_map(function ($accommodation) {

            $AddressLine2AsArray = is_array($accommodation['addresses']['address']["address_line2"]) ? $accommodation['addresses']['address']["address_line2"]
                                    : [$accommodation['addresses']['address']["address_line2"]] ;

            return [
                'id' => $accommodation['product_number'],
                'name' => $accommodation['product_name'],
                'description' => $accommodation['product_description'],
                'image' => $accommodation['product_image'],
                'owning_organisation_name' => $accommodation['owning_organisation_name'],
                'region' => $accommodation['addresses']['address']['region'] ?? "",
                'state' => $accommodation['addresses']['address']['state'] ?? "",
                'suburb' => $accommodation['addresses']['address']['city'] ?? "",
                'postcode' => $accommodation['addresses']['address']['postcode'] ?? "",
                'address' => ($accommodation['addresses']['address']["address_line"] ?? "")." "
                    . (implode(", ", $AddressLine2AsArray)),

            ];
        }, $accommodations);

        echo json_encode($accommodations);
    }

    public function getDetails($queryParams){

    }
}