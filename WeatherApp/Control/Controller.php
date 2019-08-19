<?php

namespace WeatherApp\Control;

use Exception;
use WeatherApp\Api\Bridge\OpenWeather\OpenWeatherClient;
use WeatherApp\Api\Service\CurrentWeatherService;
use WeatherApp\Api\Service\WeatherForecastService;
use WeatherApp\Api\Service\WeatherServiceAbstract;
use WeatherApp\View\WeatherView;

class Controller
{
    private $type;
    private $mode;
    private $arguments;

    function __construct($args)
    {
        $this->type=$args[1];
        $this->mode=$args[2];
        $this->arguments=array_slice($args, 3, 2);
    }

    function getRenderedWeather()
    {
        $currentWeatherService = new CurrentWeatherService(new OpenWeatherClient());
        $weatherForecastService = new WeatherForecastService(new OpenWeatherClient());

        $view = new WeatherView();
        switch ($this->type) {

            case('forecast'):
                $weather=$this->decideTypeAndReturnWeather($weatherForecastService, $this->arguments);
                return $view->renderForecast($weather);
                break;


            case( 'current' ):
                $weather=$this->decideTypeAndReturnWeather($currentWeatherService, $this->arguments);
                return $view->renderCurrent($weather);
                break;
            default:
                throw new Exception("Wrong type");

        }
    }

    private function mergeCity(array $args) : string
    {
        $array = [];
        $num=count($args);
        for ($i=0;$i<$num;$i++)
        {
            $array[$i]=$args[$i];
        }
        return join(" ",$array);
    }

    private function decideTypeAndReturnWeather(WeatherServiceAbstract $service, array $args)
    {
        switch ($this->mode) {
            case('city'):
                $city = $this->mergeCity($args);
                $weather = $service->getWeatherByCity($city);
                break;
            case('zipCode'):
                $weather = $service->getWeatherByZipCode($args[0], $args[1]);
                break;
            case('coord'):
                $weather = $service->getWeatherByCoords($args[0], $args[1]);
                break;
            default:
                throw new Exception("Wrong mode");
        }
        return $weather;
    }
}