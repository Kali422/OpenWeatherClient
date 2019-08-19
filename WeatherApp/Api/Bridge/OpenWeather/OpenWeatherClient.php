<?php

namespace WeatherApp\Api\Bridge\OpenWeather;

class OpenWeatherClient
{
    function getWeatherByCity(string $city)
    {
        $url = $this->createWeatherUrl(['q' => $city]);
        $JSON = $this->curlReturnJSON($url);
        return $JSON;
    }

    function getWeatherByCord(string $lat, string $lon)
    {
        $url = $this->createWeatherUrl(['lat' => $lat, 'lon' => $lon]);
        $JSON = $this->curlReturnJSON($url);
        return $JSON;

    }

    function getWeatherByZipCode(string $zipCode, string $countryCode)
    {
        $url = $this->createWeatherUrl(['zip' => $zipCode . "," . $countryCode]);
        $JSON = $this->curlReturnJSON($url);
        return $JSON;

    }

    function getForecastByCity(string $city)
    {
        $url = $this->createForecastUrl(['q' => $city]);
        $JSON = $this->curlReturnJSON($url);
        return $JSON;
    }

    function getForecastByCord(string $lat, string $lon)
    {
        $url = $this->createForecastUrl(['lat' => $lat, 'lon' => $lon]);
        $JSON = $this->curlReturnJSON($url);
        return $JSON;

    }

    function getForecastByZipCode(string $zipCode, string $countryCode)
    {
        $url = $this->createForecastUrl(['zip' => $zipCode . "," . $countryCode]);
        $JSON = $this->curlReturnJSON($url);
        return $JSON;

    }


     function createForecastUrl(array $params)
    {
        $url = $this->createUrl(OpenWeatherConfig::FORECAST_ENDPOINT, $params);
        return $url;
    }

     function createWeatherUrl(array $params)
    {
        $url = $this->createUrl(OpenWeatherConfig::WEATHER_ENDPOINT, $params);
        return $url;
    }


     function createUrl(string $endpoint, array $params)
    {
        $params = array_merge($params, ['appid' => OpenWeatherConfig::API_KEY, 'units' => 'metric']);

        return sprintf('%s%s?%s', OpenWeatherConfig::URL, $endpoint, http_build_query($params));
    }

    private function curlReturnJSON($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_URL => $url]);
        $json = json_decode(curl_exec($curl));
        curl_close($curl);
        return $json;
    }
}