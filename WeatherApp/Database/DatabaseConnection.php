<?php

namespace WeatherApp\Database;

use SQLite3;

class DatabaseConnection
{
    const PATH = "/var/www/html/WeatherObjects/WeatherApp/Database/WeatherDatabase";

    function ConnectToDatabase(): SQLite3
    {
        $handle = new SQLite3(self::PATH) or die("Failed connecting to database");
        return $handle;
    }


}