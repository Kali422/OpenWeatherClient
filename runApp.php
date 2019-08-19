<?php

use WeatherApp\Control\Controller;

include_once "vendor/autoload.php";

$controller = new Controller($argv);

$weather = $controller->getRenderedWeather();


echo $weather;

