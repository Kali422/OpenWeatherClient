<?php


namespace WeatherApp\Api\Service;


use WeatherApp\Api\Bridge\OpenWeather\OpenWeatherClient;

abstract class WeatherServiceAbstract
{
    /**
     * @var OpenWeatherClient
     */
    protected $openWeatherClient;

    public function __construct(OpenWeatherClient $openWeatherClient)
    {
        $this->openWeatherClient = $openWeatherClient;
    }

    abstract function getWeatherByCity(string $city);

    abstract function getWeatherByZipCode(string $zipCode, string $countryCode);

    abstract function getWeatherByCoords(float $lat, float $lon);

    protected function checkCity(string $city): bool
    {
        return preg_match("/^[a-zA-ZĘÓŁŚĄŻŹĆŃżźćńłśąęó ]{1,80}$/", $city);

    }

    protected function checkCoords($lat, $lon): bool
    {
        return ($lat <= 90 && $lat >= -90) && ($lon <= 180 && $lon >= -180);
    }

    protected function checkZipCode($zipCode): bool
    {
        return preg_match("/^[0-9]{2}-[0-9]{3}$/", $zipCode) > 0;
    }

}