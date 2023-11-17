<?php

header('Content-Type: application/json');

// Set CORS headers
header('Access-Control-Allow-Origin: http://localhost:8081'); //local
//header('Access-Control-Allow-Origin: http://54.79.206.109:8081'); //prd
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');

require_once __DIR__ . '/../vendor/autoload.php';

use Api\SydneyAreasController;
use GuzzleHttp\Exception\GuzzleException;
use Services\HttpService;

try {
    // Get the requested URL

    // passing action as part of url
     $requestUri = $_SERVER['REQUEST_URI'];

    // Remove the query string from the URL
    $requestUri = strtok($_SERVER['REQUEST_URI'], '?');

    // Remove api/
    $requestUri = str_replace("api/", "", $requestUri);

    // Remove leading and trailing slashes and explode the URL into an array
    $requestUri = trim($requestUri, '/');
    $urlSegments = explode('/', $requestUri);

     // Extract the controller name and action method
    $controllerName = snakeToCamelCase($urlSegments[0] ?? '', true);
    $controllerName .= "Controller";
    $action = $urlSegments[1] ?? 'index';



   //using old way (send action as querystring)
   /*$action = $_GET["action"] ?? null;
    $action = str_replace("api/", "", $action);
    //$actionParts =explode("/", $action);
    //$action = $actionParts[1] ?? "index";
    $controllerName= $action;//$actionParts[0] ?? null;
    // Extract the controller name and action method
    $controllerName = snakeToCamelCase($controllerName ?? '', true);
    $controllerName .= "Controller";*/

    // Define the path to the controller file
    $controllerFile = __DIR__ . '/../src/Api/' . $controllerName . '.php';

    // Check if the controller file exists
    if (file_exists($controllerFile)) {
        // Include the controller file
        require_once $controllerFile;

        // Create an instance of the controller
        $controllerClassName = "Api\\$controllerName";
        $controller = new $controllerClassName();

        // Check if the action method exists in the controller
        if (method_exists($controller, $action)) {
            // Call the action method
            $queryParams = $_GET;
            $result = $controller->$action($queryParams);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo 'Not Found - Action method not found';
        }
    } else {
        http_response_code(404);
        echo 'Not Found - Controller file not found : <br />
              Please make sure the URL contains the snake case of the controller name as its last part.<br /> 
              For example: http://127.0.0.1:8000/api/areas will invoke the index action on AreasController.<br />
              Pass any required parameters as a query string to initialize that controller';
    }
} catch (Throwable $exception) {
    // Handle general exceptions
    http_response_code(500);
    echo 'Internal Server Error - ' . $exception->getMessage();
} catch (GuzzleException $guzzleException) {
    // Handle Guzzle exceptions
    http_response_code(500);
    echo 'Internal Server Error - Guzzle Error: ' . $guzzleException->getMessage();
}

function snakeToCamelCase($input, $capitalizeFirstCharacter = true): string {
    $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $input)));
    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }
    return $str;
}
