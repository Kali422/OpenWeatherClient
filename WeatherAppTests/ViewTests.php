<?php


namespace WeatherAppTests;


use PHPUnit\Framework\TestCase;
use WeatherApp\View\WeatherView;

class ViewTests extends TestCase
{
    private $view;

    protected function setUp(): void
    {
        $this->view = new WeatherView();
    }

    /**
     * @param $temperature
     * @param $color
     * @param $expected
     * @dataProvider dataProvider
     */
    function testColorTemperature($temperature, $color, $expected)
    {
        $coloredTemperature = $this->view->colorTemperature($temperature,$color);
        $this->assertEquals($expected,$coloredTemperature);
    }

    function dataProvider()
    {
        return [
            [15,1,"\e[0;33m15\e[0m"],
            [40,3,"\e[0;31m40\e[0m"],
            [-100,0,"\e[0;34m-100\e[0m"],
            [30,3,"\e[0;31m30\e[0m"],
            [20,2,"\e[0;32m20\e[0m"],
            [10,1,"\e[0;33m10\e[0m"],
            [0,0,"\e[0;34m0\e[0m"],
            [20,-1,"20"],
            [1000,1000,"1000"],
            ];
    }

}