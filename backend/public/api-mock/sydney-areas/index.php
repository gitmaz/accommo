<?php
header('Content-Type: application/json');

// Set CORS headers
header('Access-Control-Allow-Origin: http://localhost:8080');
//$frontendOrigin = getenv('FRONTEND_ORIGIN'); //tbd
$frontendOrigin = "52.63.57.194"; //to be removed after tbd above configured
header("Access-Control-Allow-Origin: http://$frontendOrigin:8081"); //prd
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');


echo json_encode([
    ["id"=>1, "name"=>"area1"],
    ["id"=>2, "name"=>"area2"],
    ["id"=>3, "name"=>"area3"],
    ["id"=>4, "name"=>"area4"],
]);
