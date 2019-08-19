<?php


namespace WeatherAppTests;


use PHPUnit\Framework\TestCase;
use WeatherApp\Api\Bridge\OpenWeather\OpenWeatherClient;
use WeatherApp\Api\Model\Weather;
use WeatherApp\Api\Service\CurrentWeatherService;
use WeatherApp\Api\Service\WeatherForecastService;

class ServiceTests extends TestCase
{
    private $currentService;
    private $forecastService;

    function setUp(): void
    {
        $client = new OpenWeatherClient();
        $this->currentService = new CurrentWeatherService($client);
        $this->forecastService = new WeatherForecastService($client);
    }

    /**
     * @param $city
     * @param $expected
     * @dataProvider cityProvider
     */

    function testGetWeatherByCity($city, $expected)
    {
        if ($expected) {
            $weather = $this->currentService->getWeatherByCity($city);
            $this->assertInstanceOf(Weather::class, $weather);
        } else {
            $this->expectException("Exception");
            $this->currentService->getWeatherByCity($city);
        }
    }

    /**
     * @param $lat
     * @param $lon
     * @param $expected
     * @dataProvider coordsProvider
     */

    function testGetWeatherByCoords($lat, $lon, $expected)
    {
        if ($expected) {
            $weather = $this->currentService->getWeatherByCoords($lat, $lon);
            $this->assertInstanceOf(Weather::class, $weather);
        } else {
            $this->expectException("Exception");
            $this->currentService->getWeatherByCoords($lat, $lon);
        }
    }

    /**
     * @param $zipCode
     * @param $countryCode
     * @param $expected
     * @dataProvider zipCodeProvider
     */

    function testGetWeatherByZipCode($zipCode, $countryCode, $expected)
    {
        if ($expected) {
            $weather = $this->currentService->getWeatherByZipCode($zipCode, $countryCode);
            $this->assertInstanceOf(Weather::class, $weather);
        } else {
            $this->expectException("Exception");
            $this->currentService->getWeatherByZipCode($zipCode, $countryCode);
        }
    }

    /**
     * @dataProvider cityProvider
     */
    function testGetForecastByCity($city, $expected)
    {
        if ($expected) {
            $weather = $this->forecastService->getWeatherByCity($city);
            $this->assertIsArray($weather);
        } else {
            $this->expectException("Exception");
            $this->forecastService->getWeatherByCity($city);
        }
    }

    /**
     * @dataProvider coordsProvider
     */
    function testGetForecastByCoords($lat, $lon, $expected)
    {
        if ($expected) {
            $weather = $this->forecastService->getWeatherByCoords($lat, $lon);
            $this->assertIsArray($weather);
        } else {
            $this->expectException("Exception");
            $this->forecastService->getWeatherByCoords($lat, $lon);
        }
    }

    /**
     * @dataProvider zipCodeProvider
     */
    function testGetForecastByZipCode($zipCode, $countryCode, $expected)
    {
        if ($expected) {
            $weather = $this->forecastService->getWeatherByZipCode($zipCode, $countryCode);
            $this->assertIsArray($weather);
        } else {
            $this->expectException("Exception");
            $this->forecastService->getWeatherByZipCode($zipCode, $countryCode);
        }
    }

    function cityProvider()
    {
        return [["warsaw", true], ["berlin", true], ["azadsa", false]];
    }

    function coordsProvider()
    {
        return [[50, 50, true], [51, 20, true], [91, 200, false]];
    }

    function zipCodeProvider()
    {
        return [["21-500", "pl", true], ["01-123", "pl", true], ["21000", "pl", false]];
    }

}