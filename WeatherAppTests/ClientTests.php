<?php


namespace WeatherAppTests;


use PHPUnit\Framework\TestCase;
use WeatherApp\Api\Bridge\OpenWeather\OpenWeatherClient;

class ClientTests extends TestCase
{
    private $client;



    protected function setUp(): void
    {
        $this->client = new OpenWeatherClient();
    }

    /**
     * @param $endpoint
     * @param $params
     * @param $expected
     * @dataProvider urlDataProvider
     */

    function testCreateUrl($endpoint, $params, $expected)
    {
        $actual = $this->client->createUrl($endpoint,$params);
        $this->assertEquals($expected,$actual);
    }

    /**
     * @param $city
     * @param $expected
     * @dataProvider cityProvider
     */
    function testGetWeatherByCity($city)
    {
        $actual = $this->client->getWeatherByCity($city);
        $this->assertInstanceOf(\stdClass::class,$actual);
    }


    function urlDataProvider()
    {
        return [
            ['weather',["q"=>'Warsaw'],"http://api.openweathermap.org/data/2.5/weather?q=Warsaw&appid=136717e7a9a7dc52f05378023013d9d6&units=metric"],
            ['weather',["lat"=>50,"lon"=>50],"http://api.openweathermap.org/data/2.5/weather?lat=50&lon=50&appid=136717e7a9a7dc52f05378023013d9d6&units=metric"],
            ['forecast',["q"=>'Warsaw'],"http://api.openweathermap.org/data/2.5/forecast?q=Warsaw&appid=136717e7a9a7dc52f05378023013d9d6&units=metric"],
            ['forecast',["lat"=>50,"lon"=>50],"http://api.openweathermap.org/data/2.5/forecast?lat=50&lon=50&appid=136717e7a9a7dc52f05378023013d9d6&units=metric"]

        ];
    }
    public function cityProvider()
    {
        return [['berlin'],['warsaw'],['asda'],['gfsdaf'],['paris'],[123]];
    }

}