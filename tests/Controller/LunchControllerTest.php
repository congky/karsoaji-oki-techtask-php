<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LunchControllerTest extends WebTestCase
{

    public function testLunch()
    {
        $client = static::createClient();

        $client->request('GET', '/lunch');

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("200", $content["code"]);
        $this->assertEquals("OK", $content["status"]);
        $this->assertEquals(4, count($content["response"]));
        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );
    }

    public function testLunchWithUseBy()
    {
        $client = static::createClient();

        $client->request('GET', '/lunch?use-by=2019-03-27');

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("200", $content["code"]);
        $this->assertEquals("OK", $content["status"]);
        $this->assertEquals(2, count($content["response"]));
        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );
    }

    public function testLunchWithUseByAndBestBefore()
    {
        $client = static::createClient();

        $client->request('GET', '/lunch?use-by=2019-03-08&best-before=2019-03-09');

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("200", $content["code"]);
        $this->assertEquals("OK", $content["status"]);
        $this->assertEquals(3, count($content["response"]));
        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );
    }

}