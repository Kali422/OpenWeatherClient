<?php


namespace WeatherApp\Api\Service;


use Exception;
use stdClass;
use WeatherApp\Api\Model\WeatherFactory;

class WeatherForecastService extends WeatherServiceAbstract
{

    function getWeatherByCity(string $city): array
    {
        if (false == $this->checkCity($city)) {
            throw new Exception("Wrong city");
        }

        $forecastJSON = $this->openWeatherClient->getForecastByCity($city);

        return $this->returnForecastArray($forecastJSON);
    }

    function getWeatherByZipCode(string $zipCode, string $countryCode): array
    {
        if ($countryCode == 'pl' && false == $this->checkZipCode($zipCode)) {
            throw new Exception("Wrong zip code for Poland");
        }

        $forecastJSON = $this->openWeatherClient->getForecastByZipCode($zipCode, $countryCode);

        return $this->returnForecastArray($forecastJSON);
    }

    function getWeatherByCoords(float $lat, float $lon): array
    {
        if (false == $this->checkCoords($lat, $lon)) {
            throw new Exception("Wrong coordinates");
        }

        $forecastJSON = $this->openWeatherClient->getForecastByCord($lat, $lon);

        return $this->returnForecastArray($forecastJSON);
    }

    private function returnForecastArray(stdClass $forecastJSON): array
    {
        if ($forecastJSON->cod!=200)
            throw new Exception("Wrong arguments");
        $numOfWeathers = count($forecastJSON->list);
        $forecastArray = array();

        for ($i = 0; $i < $numOfWeathers; $i++) {
            $forecastArray[$i] = WeatherFactory::createWeatherInstanceFromForecast($forecastJSON, $i);
        }
        return $forecastArray;
    }
}