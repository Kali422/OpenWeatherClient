<?php

namespace WeatherApp\Database\Post;

use SQLite3Result;
use WeatherApp\Database\DatabaseConnection;

class reader
{
    private $handle;

    function __construct()
    {
        $this->handle = (new DatabaseConnection())->ConnectToDatabase();
    }

    function printJSON(string $tableName)
    {
        $forecast = $this->getForecastFromDatabase($tableName);
        $arrayForecast = $this->createArray($forecast, $tableName);
        $json = $this->createJSON($arrayForecast);
        echo $json;
    }

    private function createJSON(array $weatherArray)
    {
        return json_encode($weatherArray, JSON_PRETTY_PRINT);
    }

    private function createArray(SQLite3Result $result, $tableName): array
    {
        $output['city'] = $tableName;
        while ($row = $result->fetchArray()) {
            $weather = [
                'status' => $row['status'],
                'description' => $row['description'],
                'temperature' => $row['temperature'],
                'pressure' => $row['pressure'],
                'humidity' => $row['humidity'],
                'windSpeed' => $row['windSpeed']
            ];
            $output[$row['date']] = $weather;

        }
        return $output;
    }

    private function getForecastFromDatabase(string $tableName): SQLite3Result
    {
        $query = <<<"SQL"
select * from $tableName
SQL;
        $result = $this->handle->query($query);

        return $result;

    }

    function __destruct()
    {
        $this->handle->close();
    }
}