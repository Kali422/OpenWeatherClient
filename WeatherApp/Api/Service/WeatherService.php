<?php

namespace WeatherApp\Api\Service;

use Exception;
use stdClass;
use WeatherApp\Api\Bridge\OpenWeather\OpenWeatherClient;
use WeatherApp\Api\Model\Weather;
use WeatherApp\Api\Model\WeatherFactory;

class WeatherService
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

    function getCurrentWeatherByCity(string $city): Weather
    {

        if (false == $this->checkCity($city)) {
            throw new Exception("Wrong city");
        }
        $weatherJSON = $this->openWeatherClient->getWeatherByCity($city);
        $weather = $this->weatherFactory->createWeatherInstanceFromCurrentWeather($weatherJSON);

        return $weather;

    }

    function getCurrentWeatherByCord(string $lat, string $lon): Weather
    {
        if (false == $this->checkCoord($lat, $lon)) {
            throw new Exception("Wrong coordinates");
        }
        $weatherJSON = $this->openWeatherClient->getWeatherByCord($lat, $lon);

        $weather = $this->weatherFactory->createWeatherInstanceFromCurrentWeather($weatherJSON);
        return $weather;

    }

    function getCurrentWeatherByZipCode(string $zipCode, string $countryCode): Weather
    {
        if ($countryCode == 'pl' && false == $this->checkZipCode($zipCode)) {
            throw new Exception("Wrong zipcode for Poland");
        }
        $weatherJSON = $this->openWeatherClient->getWeatherByZipCode($zipCode, $countryCode);
        $weather = $this->weatherFactory->createWeatherInstanceFromCurrentWeather($weatherJSON);
        return $weather;
    }

    function getForecastWeatherByCity(string $city): array
    {
        if (false == $this->checkCity($city)) {
            throw new Exception("Wrong city");
        }

        $forecastJSON = $this->openWeatherClient->getForecastByCity($city);

        return $this->returnForecastArray($forecastJSON);

    }

    function getForecastWeatherByCord(string $lat, string $lon): array
    {
        if (false == $this->checkCoord($lat, $lon)) {
            throw new Exception("Wrong coordinates");
        }

        $forecastJSON = $this->openWeatherClient->getForecastByCord($lat, $lon);

        return $this->returnForecastArray($forecastJSON);
    }

    function getForecastWeatherByZipCode(string $zipCode, string $countryCode): array
    {
        if ($countryCode == 'pl' && false == $this->checkZipCode($zipCode)) {
            throw new Exception("Wrong zip code for Poland");
        }

        $forecastJSON = $this->openWeatherClient->getForecastByZipCode($zipCode, $countryCode);

        return $this->returnForecastArray($forecastJSON);
    }

    function returnForecastArray(stdClass $forecastJSON): array
    {
        $numOfWeathers = count($forecastJSON->list);
        $forecastArray = array();

        for ($i = 0; $i < $numOfWeathers; $i++) {
            $forecastArray[$i] = $this->weatherFactory->createWeatherInstanceFromForecast($forecastJSON, $i);
        }
        return $forecastArray;
    }

    private function checkCity(string $city): bool
    {
        return preg_match("/^[a-zA-ZĘÓŁŚĄŻŹĆŃżźćńłśąęó ]{1,80}$/", $city);

    }

    private function checkCoord($lat, $lon): bool
    {
        return ($lat <= 90 && $lat >= -90) || ($lon <= 90 && $lon >= -90);
    }

    private function checkZipCode($zipCode): bool
    {
        return preg_match("/^[0-9]{2}-[0-9]{3}$/", $zipCode) > 0;
    }


}