<?php
header('Content-Type: application/json');

// Set CORS headers
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Origin: http://54.79.206.109:8081'); //prd
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');


echo json_encode([
    ["id"=>1, "name"=>"area1"],
    ["id"=>2, "name"=>"area2"],
    ["id"=>3, "name"=>"area3"],
    ["id"=>4, "name"=>"area4"],
]);
