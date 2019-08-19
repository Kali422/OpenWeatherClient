<?php

namespace WeatherApp\View;

use WeatherApp\Api\Model\Weather;

class WeatherView
{

    function renderCurrent(Weather $weather)
    {
        $output = <<<ABC
Current weather in: {$weather->getCity()}, {$weather->getCountry()}
Last update: {$weather->getDate()}

ABC;
        $output .= $this->render($weather);
        return $output;


    }

    private function render(Weather $weather): string
    {
        $temperature = $this->colorTemperature($weather->getTemperature(), $weather->getTemperatureColor());

        $output = <<<ABC
Weather status: {$weather->getStatus()}
Description: {$weather->getDescription()}
Temperature: {$temperature} degree Celsius
Pressure: {$weather->getPressure()} hPa
Humidity: {$weather->getHumidity()} %
Wind speed: {$weather->getWindSpeed()} m/s


ABC;

        return $output;
    }

    function colorTemperature($temperature, $temperatureColor)
    {
        switch ($temperatureColor) {
            case(3):
                $coloredTemperature = "\e[0;31m$temperature\e[0m";
                break;
            case (2):
                $coloredTemperature = "\e[0;32m$temperature\e[0m";
                break;
            case (1):
                $coloredTemperature = "\e[0;33m$temperature\e[0m";
                break;
            case (0):
                $coloredTemperature = "\e[0;34m$temperature\e[0m";
                break;
            default:
                $coloredTemperature = $temperature;
                break;
        }
        return $coloredTemperature;
    }

    function renderForecast(array $forecast)
    {
        $output = "Weather forecast for {$forecast[0]->getCity()}, {$forecast[0]->getCountry()}\n";
        $numOfForecast = count($forecast);
        for ($i = 0; $i < $numOfForecast; $i++) {
            $output .= "Time: {$forecast[$i]->getDate()}\n" . $this->render($forecast[$i]);
        }
        return $output;

    }


}