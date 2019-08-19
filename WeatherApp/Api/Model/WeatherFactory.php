<?php

namespace WeatherApp\Api\Model;

use DateTime;
use stdClass;

class WeatherFactory
{
    static function createWeatherInstanceFromCurrentWeather(stdClass $weatherJSON): Weather
    {
        if ($weatherJSON->cod != 200)
            throw new \Exception("$weatherJSON->message");
        elseif (false == isset($weatherJSON->name) || false == isset($weatherJSON->sys->country)) {
            throw new \Exception("Something is wrong");
        } else {
            $date = self::convertDateTime($weatherJSON->dt);
            $city = $weatherJSON->name;
            $country = $weatherJSON->sys->country;
            $status = $weatherJSON->weather[0]->main;
            $description = $weatherJSON->weather[0]->description;
            $temperature = $weatherJSON->main->temp;
            $pressure = $weatherJSON->main->pressure;
            $humidity = $weatherJSON->main->humidity;
            $windSpeed = $weatherJSON->wind->speed;

            $temperatureColor = self::getTemperatureColor($temperature);

            return new Weather($date, $city, $country, $status, $description, $temperature, $pressure, $humidity, $windSpeed, $temperatureColor);
        }
    }

    static function createWeatherInstanceFromForecast(stdClass $forecastJSON, int $i): Weather
    {
        if ($forecastJSON->cod != 200) {
            throw new \Exception("$forecastJSON->message");
        } elseif (false == isset($forecastJSON->city->name) || false == isset($forecastJSON->city->country)) {
            throw new \Exception("Something is wrong");
        } elseif ($i<40)
        {
            $date = self::convertDateTime($forecastJSON->list[$i]->dt);
            $city = $forecastJSON->city->name;
            $country = $forecastJSON->city->country;
            $status = $forecastJSON->list[$i]->weather[0]->main;
            $description = $forecastJSON->list[$i]->weather[0]->description;
            $temperature = $forecastJSON->list[$i]->main->temp;
            $pressure = $forecastJSON->list[$i]->main->pressure;
            $humidity = $forecastJSON->list[$i]->main->humidity;
            $windSpeed = $forecastJSON->list[$i]->wind->speed;

            $temperatureColor = self::getTemperatureColor($temperature);

            return new Weather($date, $city, $country, $status, $description, $temperature, $pressure, $humidity, $windSpeed, $temperatureColor);
        }
        else throw new \Exception("Wrong number");
    }


    private static function convertDateTime(int $time): string
    {
        $date = new DateTime();
        $date->setTimestamp($time);
        return $date->format('Y-m-d H:i:s');
    }


    private static function getTemperatureColor($temperature)
    {
        switch ($temperature) {
            case($temperature >= 30):
                return 3;
                break;
            case ($temperature >= 20 && $temperature < 30):
                return 2;
                break;
            case ($temperature >= 10 && $temperature < 20):
                return 1;
                break;
            case ($temperature < 10):
                return 0;
                break;
            default:
                return -1;
                break;
        }
    }
}