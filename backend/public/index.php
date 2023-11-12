<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Api\SydneyAreasController;


// Get the requested URL
$requestUri = $_SERVER['REQUEST_URI'];

// Remove the query string from the URL
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');

// Remove api/
$requestUri = str_replace("api/", "", $requestUri);

// Remove leading and trailing slashes and explode the URL into an array
$requestUri = trim($requestUri, '/');

$requestUri = trim($requestUri, '/');
$urlSegments = explode('/', $requestUri);

// Extract the controller name and action method
$controllerName = snakeToCamelCase($urlSegments[0] ?? '', true);
$controllerName .="Controller";

$action = $urlSegments[1] ?? 'index';

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
        $controller->$action($queryParams);
    } else {
        http_response_code(404);
        echo 'Not Found - Action method not found';
    }
} else {
    http_response_code(404);
    echo 'Not Found - Controller file not found : <br />
          Please make sure url contains snake case of controller name as its last part.<br /> 
          For example: http://127.0.0.1:8000/api/areas will invoke index action on AreasController.<br />
          Pass any required parameter as query string, to initialise that controller';
}



function snakeToCamelCase($input, $capitalizeFirstCharacter = true) {
    $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $input)));
    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }
    return $str;
}