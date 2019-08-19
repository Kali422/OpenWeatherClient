<?php

namespace WeatherApp\Api\Service;

use Cmfcmf\OpenWeatherMap;
use Http\Adapter\Guzzle6\Client;
use Http\Factory\Guzzle\RequestFactory;
use WeatherApp\Api\Bridge\OpenWeather\OpenWeatherClient;
use WeatherApp\Api\Bridge\OpenWeather\OpenWeatherConfig;
use WeatherApp\Api\Model\WeatherFactory;

class ExternalService
{
    /**
     * @var WeatherFactory
     */
    private $weatherFactory;
    /**
     * @var OpenWeatherClient
     */
    private $openWeatherClient;

    public function __construct(WeatherFactory $weatherFactory, OpenWeatherClient $openWeatherClient)
    {
        $this->weatherFactory = $weatherFactory;
        $this->openWeatherClient = $openWeatherClient;
    }

    function getExternalApiCurrentWeather($query)
    {
        $httpRequestFactory = new RequestFactory();
        $httpClient = Client::createWithConfig([]);

        $owi = new OpenWeatherMap(OpenWeatherConfig::API_KEY, $httpClient, $httpRequestFactory);

        $weatherJSON = $owi->getRawWeatherData($query, "metric", "en", null, 'json');

        $weatherJSON = json_decode($weatherJSON);

        return $this->weatherFactory->createWeatherInstanceFromCurrentWeather($weatherJSON);
    }

    function getExternalApiForecast($query)
    {
        $httpRequestFactory = new RequestFactory();
        $httpClient = Client::createWithConfig([]);

        $owi = new OpenWeatherMap(OpenWeatherConfig::API_KEY, $httpClient, $httpRequestFactory);

        $weatherJSON = $owi->getRawHourlyForecastData($query, "metric", "en", null, 'json');

        $weatherJSON = json_decode($weatherJSON);

        $service = new WeatherService($this->weatherFactory, $this->openWeatherClient);

        return $service->returnForecastArray($weatherJSON);


    }
}