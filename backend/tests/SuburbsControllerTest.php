<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class SuburbsControllerTest extends TestCase
{
    public function testSuburbsControllerReturnsIngleburn()
    {
        // Replace this URL with the actual URL of your API
        //todo: move all urls to a config file
        $apiUrl = 'http://127.0.0.1:8000/api/suburbs';

        $client = new Client();
        $response = $client->get($apiUrl);

        $this->assertEquals(200, $response->getStatusCode());

        $suburbs = json_decode($response->getBody()->getContents(), true);

        // Check if Ingleburn is in the list of suburbs
        $ingleburnFound = false;
        foreach ($suburbs as $suburb) {
            if ($suburb['Name'] === 'Ingleburn') {
                $ingleburnFound = true;
                break;
            }
        }

        $this->assertTrue($ingleburnFound, 'Ingleburn should be in the list of suburbs.');
    }
}
