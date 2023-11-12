<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class SydneyAreasControllerTest extends TestCase
{
    public function testIndexReturnsCorrectJson()
    {
        // Replace this URL with the actual URL of your API
        //todo: move all urls to a config file
        $apiUrl = 'http://127.0.0.1:8000/api/sydney-areas';

        $client = new Client();
        $response = $client->get($apiUrl);

        $this->assertEquals(200, $response->getStatusCode());

        $expectedJson = '[{"AreaId":"29000677","Name":"Inner Sydney"},{"AreaId":"29000678","Name":"Sydney City"},{"AreaId":"29000679","Name":"Sydney East"},{"AreaId":"29000680","Name":"Sydney North"},{"AreaId":"29000681","Name":"Sydney South"},{"AreaId":"29000687","Name":"Sydney West"}]';
        $actualJson = $response->getBody()->getContents();

        $this->assertJsonStringEqualsJsonString($expectedJson, $actualJson);
    }
}
