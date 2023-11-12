<?php

namespace Api;

use Services\HttpService;

/**
 * Class AccommodationsController
 *
 * This class handles the API endpoints related to accommodations.
 *
 * @package Api
 */
class AccommodationsController
{
    /**
     * Handles the 'index' action, which retrieves a list of accommodations based on the provided filters.
     *
     * @param array $queryParams The query parameters.
     *
     * @return void
     */
    public function index(array $queryParams): void
    {
        $area = $queryParams['area'] ?? null;
        $suburb = $queryParams['suburb'] ?? null;

        if ($area === null && $suburb === null) {
            echo "at least one filter (area or suburb) should be included in the query string. For example, area=SCY or suburb=Barangaroo";
        }

        //todo: move all urls to a config file
        $httpService = new HttpService("https://atlas.atdw-online.com.au/api/atlas/");

        $areaQueryStr = $area ? ($area !== "null" ? "ar=$area" : "") : "";
        $suburbQueryStr = $suburb ? ($suburb !== "null" ? "ct=$suburb" : "") : "";
        $queryStr = $areaQueryStr ? $areaQueryStr . ($suburbQueryStr ? "&$suburbQueryStr" : "") : $suburbQueryStr;

        $accommodations = $httpService->fetch("products", "cats=ACCOMM&rg=GSY&$queryStr");

        if ($accommodations["number_of_results"] == 1) {
            $accommodations = $accommodations["products"]["product_record"] ?? [];
            $accommodations = [$accommodations];
        } else {
            $accommodations = $accommodations["products"]["product_record"] ?? [];
        }

        $accommodations = array_map(function ($accommodation) {
            $AddressLine2AsArray = is_array($accommodation['addresses']['address']["address_line2"])
                ? $accommodation['addresses']['address']["address_line2"]
                : [$accommodation['addresses']['address']["address_line2"]];

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
                'address' => ($accommodation['addresses']['address']["address_line"] ?? "") . " "
                    . (implode(", ", $AddressLine2AsArray)),
            ];
        }, $accommodations);

        echo json_encode(["results" => $accommodations, "totalPages" => 1]);
    }

    /**
     * Handles the 'getDetails' action, which retrieves details for a specific accommodation.
     *
     * @param array $queryParams The query parameters.
     *
     * @return void
     */
    public function getDetails(array $queryParams): void
    {
        // Implementation for the 'getDetails' action
    }
}
