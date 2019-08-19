<?php


namespace WeatherApp\Api\Service;


use Exception;
use WeatherApp\Api\Model\Weather;
use WeatherApp\Api\Model\WeatherFactory;

class CurrentWeatherService extends WeatherServiceAbstract
{

    function getWeatherByCity(string $city): Weather
    {
        if (false == $this->checkCity($city)) {
            throw new Exception("Wrong city");
        }
        $weatherJSON = $this->openWeatherClient->getWeatherByCity($city);
        $weather = WeatherFactory::createWeatherInstanceFromCurrentWeather($weatherJSON);

        return $weather;
    }

    function getWeatherByZipCode(string $zipCode, string $countryCode): Weather
    {
        if ($countryCode == 'pl' && false == $this->checkZipCode($zipCode)) {
            throw new Exception("Wrong zipcode for Poland");
        }
        $weatherJSON = $this->openWeatherClient->getWeatherByZipCode($zipCode, $countryCode);
        $weather = WeatherFactory::createWeatherInstanceFromCurrentWeather($weatherJSON);
        return $weather;
    }

    function getWeatherByCoords(float $lat, float $lon): Weather
    {
        if (false == $this->checkCoords($lat, $lon)) {
            throw new Exception("Wrong coordinates");
        }
        $weatherJSON = $this->openWeatherClient->getWeatherByCord($lat, $lon);

        $weather = WeatherFactory::createWeatherInstanceFromCurrentWeather($weatherJSON);
        return $weather;
    }
}