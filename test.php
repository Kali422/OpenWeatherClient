<?php

use WeatherApp\WeatherAction;


include_once "vendor/autoload.php";

//$factory = new WeatherFactory();
//$client = new OpenWeatherClient();
//$service = new WeatherService($factory,$client);

$weatherAction = new WeatherAction();

$weatherAction->run();

//$reader = new \WeatherApp\Database\Post\reader();
//
//$reader->printJSON("Warsaw");


//$weather = $service->getExternalApiForecastByCity("Warsaw");


//$forecast = $service->getForecastWeatherByCity("Chicago");
//
//$databaseService = new WeatherApp\Database\Service\WeatherDatabaseService();
//
//$databaseService->saveWeatherForecast($forecast);


// TODO:
// 1. Pobrać parametry wejściowe
// np. argv, opts, longopts
// test.php city Warszawa
// test.php zipCode 00-000
// test.php coord 00.00 11.11
// 1 warstwa (kontroler/komenda) zbiera dane, może zwalidować CZY DANE SĄ
// 2 warstwa (api) wywołuje odpowiednie serwisy, repozytoria, ale nie podejmuje decyzji o flow,o poprawności danych
    // warstwa logiki biznesowej, może mieć warunek odnośnie temperatury
    // warstwa danych, repozytoria, klienty api
// 3 prezentacje danych, widoki



