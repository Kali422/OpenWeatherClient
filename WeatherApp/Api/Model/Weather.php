<?php

namespace WeatherApp\Api\Model;

class Weather
{
    private $date;
    private $city;
    private $status;
    private $description;
    private $temperature;
    private $pressure;
    private $humidity;
    private $windSpeed;
    /**
     * @var int
     */
    private $temperatureColor;
    /**
     * @var string
     */
    private $country;

    function __construct(string $date, string $city, string $country, string $status, string $description, string $temperature, string $pressure, string $humidity, string $windSpeed, int $temperatureColor)
    {

        $this->date = $date;
        $this->city = $city;
        $this->status = $status;
        $this->description = $description;
        $this->temperature = $temperature;
        $this->pressure = $pressure;
        $this->humidity = $humidity;
        $this->windSpeed = $windSpeed;
        $this->temperatureColor = $temperatureColor;
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTemperature(): string
    {
        return $this->temperature;
    }

    /**
     * @return string
     */
    public function getPressure(): string
    {
        return $this->pressure;
    }

    /**
     * @return string
     */
    public function getHumidity(): string
    {
        return $this->humidity;
    }

    /**
     * @return string
     */
    public function getWindSpeed(): string
    {
        return $this->windSpeed;
    }

    /**
     * @return int
     */
    public function getTemperatureColor(): int
    {
        return $this->temperatureColor;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }


}