<?php

namespace WeatherApp;

use WeatherApp\Api\Bridge\OpenWeather\OpenWeatherClient;
use WeatherApp\Database\ModelDatabase\WeatherSaver;
use WeatherApp\Database\Service\WeatherDatabaseService;
use WeatherApp\Api\Model\WeatherFactory;
use WeatherApp\Api\Service\WeatherService;
use WeatherApp\View\WeatherView;


class WeatherAction
{
    public function run()
    {
        $service = new WeatherService(new WeatherFactory(), new OpenWeatherClient());

        $current = $service->getCurrentWeatherByCity("Oslo");
        $currentCord = $service->getCurrentWeatherByCord(70.015842, 23.292412);
        $currentZipCode = $service->getCurrentWeatherByZipCode("155 00", "cz");

        $forecastCity = $service->getForecastWeatherByCity("Wrocław");
        $forecastCord = $service->getForecastWeatherByCord(70.015842, 23.292412);
        $forecastZipCode = $service->getForecastWeatherByZipCode("21-500", "pl");

//        $currentExternal = $service->getExternalApiCurrentWeather(array("lat"=>50,"lon"=>50));
//
//        $forecastExternal = $service->getExternalApiForecast("Chicago");
//
//        $currentZipExternal = $service->getExternalApiCurrentWeather("zip:21-500,pl");

        $view = new WeatherView();

        echo $view->renderCurrent($current);

//        echo $view->renderCurrent($currentExternal);
//
//        echo $view->renderCurrent($currentCord);
//
//        echo $view->renderForecast($forecastCity);

        $service = new WeatherDatabaseService(new WeatherSaver());

        //$service->saveWeatherForecast($forecastCord);
        $service->saveCurrentWeather($currentZipCode);
    }
}