<?php


namespace WeatherApp\Database\ModelDatabase;

use SQLite3;
use WeatherApp\Api\Model\Weather;

class WeatherSaver
{


    function checkIfTableExists(Weather $weather, SQLite3 $handle): bool
    {
        $tableName = str_replace(" ", "_", $weather->getCity());
        $sql = "SELECT count(name) from sqlite_master where type='table' and name='{$tableName}'";
        $result = $handle->querySingle($sql);
        if ($result > 0)
            return true;
        else return false;
    }

    function insertRow(Weather $weather, SQLite3 $handle): void
    {
        $tableName = str_replace(" ", "_", $weather->getCity());
        $date = $weather->getDate();
        $status = $weather->getStatus();
        $description = $weather->getDescription();
        $temperature = $weather->getTemperature();
        $pressure = $weather->getPressure();
        $humidity = $weather->getHumidity();
        $windSpeed = $weather->getWindSpeed();
        $sql = <<<"SQL"
insert or replace into "{$tableName}" (date, status, description, temperature, pressure, humidity, windSpeed)
VALUES ("$date","$status","$description","$temperature","$pressure","$humidity","$windSpeed");
SQL;

        $handle->query($sql);


    }

    function createTable($tableName, SQLite3 $handle): void
    {
        $tableName = str_replace(" ", "_", $tableName);
        $sql = <<<SQL
create table '{$tableName}' (
    'id' integer primary key autoincrement not null,
    'date' text unique,
    'status' text,
    'description' text,
    'temperature' real,
    'pressure' real,
    'humidity' integer,
    'windSpeed' real)
SQL;
        $handle->query($sql);
    }

}