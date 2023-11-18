<?php
header('Content-Type: application/json');

// Set CORS headers
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Origin: http://54.206.184.124:8081'); //prd
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');


echo json_encode([ "results" => [
        [
            "id"=>1,
            "name"=>"acco1",
            "image" => "https://assets.atdw-online.com.au//images//af0a09cc1b404c39ee4dc7837ff59fbe.jpeg?rect=0%2C480%2C1280%2C960&w=280&h=210&rot=360&q=eyJ0eXBlIjoibGlzdGluZyIsImxpc3RpbmdJZCI6IjYwNzY4OWNhOGViMzY1OGUwNGQxZWQ2YiIsImRpc3RyaWJ1dG9ySWQiOiI1NmIxZWI5MzQ0ZmVjYTNkZjJlMzIwYzgiLCJhcGlrZXlJZCI6IjU2YjFlZTU5MGNmMjEzYWQyMGRjNTgxOSJ9",
            "description" => "description 1",
            "address" =>  "address 1",
        ],
        [
            "id"=>2,
            "name"=>"acco2",
            "image" => "https://assets.atdw-online.com.au//images//af0a09cc1b404c39ee4dc7837ff59fbe.jpeg?rect=0%2C480%2C1280%2C960&w=280&h=210&rot=360&q=eyJ0eXBlIjoibGlzdGluZyIsImxpc3RpbmdJZCI6IjYwNzY4OWNhOGViMzY1OGUwNGQxZWQ2YiIsImRpc3RyaWJ1dG9ySWQiOiI1NmIxZWI5MzQ0ZmVjYTNkZjJlMzIwYzgiLCJhcGlrZXlJZCI6IjU2YjFlZTU5MGNmMjEzYWQyMGRjNTgxOSJ9",
            "description" => "description 2",
            "address" =>  "address 2",
        ],
        [
            "id"=>3,
            "name"=>"acco3",
            "image" => "https://assets.atdw-online.com.au//images//af0a09cc1b404c39ee4dc7837ff59fbe.jpeg?rect=0%2C480%2C1280%2C960&w=280&h=210&rot=360&q=eyJ0eXBlIjoibGlzdGluZyIsImxpc3RpbmdJZCI6IjYwNzY4OWNhOGViMzY1OGUwNGQxZWQ2YiIsImRpc3RyaWJ1dG9ySWQiOiI1NmIxZWI5MzQ0ZmVjYTNkZjJlMzIwYzgiLCJhcGlrZXlJZCI6IjU2YjFlZTU5MGNmMjEzYWQyMGRjNTgxOSJ9",
            "description" => "description 3",
            "address" =>  "address 3",
        ],
        [
            "id"=>4,
            "name"=>"acco4",
            "image" => "https://assets.atdw-online.com.au//images//af0a09cc1b404c39ee4dc7837ff59fbe.jpeg?rect=0%2C480%2C1280%2C960&w=280&h=210&rot=360&q=eyJ0eXBlIjoibGlzdGluZyIsImxpc3RpbmdJZCI6IjYwNzY4OWNhOGViMzY1OGUwNGQxZWQ2YiIsImRpc3RyaWJ1dG9ySWQiOiI1NmIxZWI5MzQ0ZmVjYTNkZjJlMzIwYzgiLCJhcGlrZXlJZCI6IjU2YjFlZTU5MGNmMjEzYWQyMGRjNTgxOSJ9",
            "description" => "description 4",
            "address" =>  "address 4",
        ],
    ],
    "totalPages" => 1
]);
