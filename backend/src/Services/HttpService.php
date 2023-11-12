<?php
namespace Services;

use GuzzleHttp\Client;

class HttpService
{

    private $baseUrl;
    private $apiKey="123456789101112";
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function fetch($relUrl, ?string $queryString=null)
    {
        $client = new Client();
        $response = $client->get($this->baseUrl ."/".$relUrl. "?key={$this->apiKey}&" . $queryString); // Adjust the URL accordingly
        $resulstXml = $response->getBody()->getContents();

        // Parse XML to an associative array (you may need to adjust this based on the actual XML structure)
        $resultsArray = json_decode(json_encode(simplexml_load_string($resulstXml)), true);

        return $resultsArray;
    }
}