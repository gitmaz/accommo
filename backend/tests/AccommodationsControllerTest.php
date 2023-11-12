<?php


use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class AccommodationsControllerTest extends TestCase
{
    public function testAccommodationsInAreaSCY()
    {
        // Url for accommodations in SCY (Sydney City)
        //todo: move all urls to a config file
        $apiUrlSCY = 'http://127.0.0.1:8000/api/accommodations?area=SCY';

        $client = new Client();
        $responseSCY = $client->get($apiUrlSCY);

        $this->assertEquals(200, $responseSCY->getStatusCode());

        $accommodationsSCY = json_decode($responseSCY->getBody()->getContents(), true);

        // Check if there is at least one accommodation in the area "SCY"
        $this->assertNotEmpty($accommodationsSCY);

        return $accommodationsSCY;
    }

    public function testAccommodationsInSuburbBarangaroo()
    {
        // Url for accommodations in SCY
        $apiUrlSCY = 'http://127.0.0.1:8000/accommodations?area=SCY';

        $client = new Client();
        $responseSCY = $client->get($apiUrlSCY);

        $this->assertEquals(200, $responseSCY->getStatusCode());

        $accommodationsSCY = json_decode($responseSCY->getBody()->getContents(), true);

        // Check if there is at least one accommodation in the area "SCY"
        $this->assertNotEmpty($accommodationsSCY);

        // Url for accommodations in Barangaroo
        $apiUrlBarangaroo = 'http://127.0.0.1:8000/accommodations?suburb=Barangaroo';

        $responseBarangaroo = $client->get($apiUrlBarangaroo);

        $this->assertEquals(200, $responseBarangaroo->getStatusCode());

        $accommodationsBarangaroo = json_decode($responseBarangaroo->getBody()->getContents(), true);

        // Check if accommodations in Barangaroo are included in accommodations in SCY (as Barangaroo is a suburb of Sydney City)
        foreach ($accommodationsBarangaroo as $accommodation) {
            $this->assertContains($accommodation, $accommodationsSCY);
        }
    }
}
