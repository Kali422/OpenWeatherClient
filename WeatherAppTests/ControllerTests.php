<?php


namespace WeatherAppTests;


use PHPUnit\Framework\TestCase;
use WeatherApp\Control\Controller;

class ControllerTests extends TestCase
{
    /**
     * @param $args
     * @param $expected
     * @throws \Exception
     * @dataProvider argsProvider
     */
    function testController($args, $expected)
    {
        if ($expected) {
            $controller = new Controller($args);
            $weather = $controller->getRenderedWeather();
            $this->assertIsString($weather);
        } else {
            $this->expectException("Exception");
            $controller = new Controller($args);
            $controller->getRenderedWeather();
        }
    }

    function argsProvider()
    {
        return [
            [["x", "current", "city", "Warsaw"], true],
            [["x", "current", "zipCode", "21-500", "pl"], true],
            [["x", "current", "coord", 50, 50], true],
            [["x", "current", "city", "assd"], false],
            [["x", "current", "zipCode", "21500", "pl"], false],
            [["x", "current", "coord", 0, 0], false],
            [["x", "current", "city", "berlin"], true],
            [["x", "current", "zipCode", "07039", "us"], true],
            [["x", "current", "coord", 51, 20], true],
            [["x", "current", "city", "war","saw"], false],
            [["x", "current", "zipCode", "war saw", "pl"], false],
            [["x", "current", "coord", -91, 192], false],
            [["x", "current", "city", "biała","podlaska"], true]
        ];
    }

}