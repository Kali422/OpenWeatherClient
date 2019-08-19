<?php


namespace WeatherAppTests;


use PHPUnit\Framework\TestCase;
use WeatherApp\Api\Bridge\OpenWeather\OpenWeatherClient;
use WeatherApp\Api\Model\Weather;
use WeatherApp\Api\Model\WeatherFactory;

class FactoryTests extends TestCase
{
    private $client;

    function setUp(): void
    {
        $this->client = new OpenWeatherClient();
    }

    /**
     * @dataProvider cityProvider
     */
    function testCreateCurrentWeatherByCity($city, $expected)
    {
        $json = $this->client->getWeatherByCity($city);
        if ($expected) {
            $weather = WeatherFactory::createWeatherInstanceFromCurrentWeather($json);
            $this->assertInstanceOf(Weather::class, $weather);
        } else {
            $this->expectException("Exception");
            WeatherFactory::createWeatherInstanceFromCurrentWeather($json);
        }
    }

    /**
     * @dataProvider coordProvider
     */

    function testCreateCurrentWeatherByCoords($lat, $lon, $expected)
    {
        $json = $this->client->getWeatherByCord($lat, $lon);
        if ($expected) {
            $weather = WeatherFactory::createWeatherInstanceFromCurrentWeather($json);
            $this->assertInstanceOf(Weather::class, $weather);
        } else {
            $this->expectException("Exception");
            WeatherFactory::createWeatherInstanceFromCurrentWeather($json);
        }
    }

    /**
     * @dataProvider zipCodeProvider
     */

    function testCreateCurrentWeatherByZipCode($zipCode, $countryCode, $expected)
    {
        $json = $this->client->getWeatherByZipCode($zipCode, $countryCode);
        if ($expected) {
            $weather = WeatherFactory::createWeatherInstanceFromCurrentWeather($json);
            $this->assertInstanceOf(Weather::class, $weather);
        } else {
            $this->expectException("Exception");
            $weather = WeatherFactory::createWeatherInstanceFromCurrentWeather($json);
        }
    }

    /**
     * @param $city
     * @param $i
     * @param $expected
     * @throws \Exception
     * @dataProvider cityForForecastProvider
     */

    function testCreateWeatherForecastByCity($city,$i, $expected)
    {
        $json = $this->client->getForecastByCity($city);
        if ($expected) {
            $weather = WeatherFactory::createWeatherInstanceFromForecast($json, $i);
            $this->assertInstanceOf(Weather::class, $weather);
        }
        else{
            $this->expectException("Exception");
            WeatherFactory::createWeatherInstanceFromForecast($json,$i);
        }

    }


    function cityProvider()
    {
        return [['warsaw', true], ['berlin', true], ['pwo31', false], ['qwe', false], ['', false]];
    }

    function coordProvider()
    {
        return [[52.231139, 20.997464, true], [52.473929, 20.654870, true], [55.685135, 37.691780, true], [0, 0, false], [91, 182, false]];
    }

    function zipCodeProvider()
    {
        return [["21-500", "pl", true], ["01-123", "pl", true], ["07039", "us", true], ["104 00", "cz", true], ["2314123", "ls", false], ["092031", "2132", false], ["oasdk", "dals", false]];
    }


    function cityForForecastProvider()
    {
        return [["warsaw",1,true],["berlin",10,true],["prague",50,false],["asdaff",10,false]];
    }


}