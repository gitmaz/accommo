<?php
header('Content-Type: application/json');

// Set CORS headers
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');


echo json_encode([ "results" => [
        ["id"=>1, "name"=>"acco1"],
        ["id"=>2, "name"=>"acco2"],
        ["id"=>3, "name"=>"acco3"],
        ["id"=>4, "name"=>"acco4"],
    ],
    "totalPages" => 1
]);
