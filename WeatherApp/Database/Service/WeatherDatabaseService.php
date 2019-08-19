<?php

namespace WeatherApp\Database\Service;

use WeatherApp\Database\DatabaseConnection;
use WeatherApp\Database\ModelDatabase\WeatherSaver;
use WeatherApp\Api\Model\Weather;

class WeatherDatabaseService
{
    private $saver;

    function __construct(WeatherSaver $saver)
    {
        $this->saver = $saver;
    }

    function saveCurrentWeather(Weather $weather)
    {

        $handle = (new DatabaseConnection())->ConnectToDatabase();
        if (false == $this->saver->checkIfTableExists($weather, $handle)) {
            $this->saver->createTable($weather->getCity(), $handle);
        }
        $this->saver->insertRow($weather, $handle);
        $handle->close();

    }

    function saveWeatherForecast(array $forecast)
    {
        $numOfRows = count($forecast);

        $this->saver = new WeatherSaver();

        $handle = (new DatabaseConnection())->ConnectToDatabase();

        if (false == $this->saver->checkIfTableExists($forecast[0], $handle)) {
            $this->saver->createTable($forecast[0]->getCity(), $handle);
        }

        for ($i = 0; $i < $numOfRows; $i++) {
            $this->saver->insertRow($forecast[$i], $handle);
        }
        $handle->close();

    }

}