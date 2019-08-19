<?php

use WeatherApp\Database\Post\reader;

include_once "vendor/autoload.php";


$weatherAction = new reader();

$weatherAction->printJSON($_GET['q']);



