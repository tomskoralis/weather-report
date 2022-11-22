<?php

require_once 'app/constants.php';

use App\{WeatherCurrently, WeatherForecastHourly, WeatherForecasts};
use const App\{DAYS};

if (isset($_GET["type"])) {
    switch ($_GET["type"]) {
        case "current":
            $currentWeather = new WeatherCurrently($_GET["location"]);
            if ($currentWeather->getWeatherData() !== null) {
                echo "<table class='current'> " . PHP_EOL;
                echo "<thead><tr><th colspan='2'>Current weather for {$currentWeather->getCity()}, {$currentWeather->getCountry()}</th></tr></thead>" . PHP_EOL;
                echo "<tbody><tr><td>Temperature:</td><td>{$currentWeather->getTemperature()}</td></tr> " . PHP_EOL;
                if (
                    $currentWeather->getTemperatureMin() !== $currentWeather->getTemperature() &&
                    $currentWeather->getTemperatureMax() !== $currentWeather->getTemperature()
                ) {
                    echo "<tr><td></td><td>{$currentWeather->getTemperatureMin()} ~ {$currentWeather->getTemperatureMax()}</td></tr> " . PHP_EOL;
                }
                echo "<tr><td>Weather:</td><td>{$currentWeather->getWeather()}</td></tr> " . PHP_EOL;
                echo "<tr><td>Precipitation:</td><td>{$currentWeather->getPrecipitation()}</td></tr> " . PHP_EOL;
                echo "<tr><td>Humidity:</td><td>{$currentWeather->getHumidity()}</td></tr> " . PHP_EOL;
                echo "<tr><td>Wind:</td><td>{$currentWeather->getWindSpeed()} from {$currentWeather->getWindDirection()}</td></tr> " . PHP_EOL;
                echo "</tbody></table> " . PHP_EOL;
                echo "</div><div id='end'><footer>The data was updated at {$currentWeather->getTime()} local time</footer></div> " . PHP_EOL;
            }
            break;
        case "forecast":
            $weatherForecasts = new WeatherForecasts($_GET["location"], DAYS);
            if ($weatherForecasts->getForecastData() !== null) {
                echo "<table class='forecast'> " . PHP_EOL;
                echo "<thead><tr><th colspan='4'>" . DAYS . " day weather forecast for {$weatherForecasts->getCity()}, {$weatherForecasts->getCountry()}</th></tr> " . PHP_EOL;
                echo "<tr><th>Time</th><th>Temperature</th><th>Weather</th></tr></thead> " . PHP_EOL;
                echo "<tbody> " . PHP_EOL;
                while ($weatherForecasts->canGetForecast()) {
                    $forecast = new WeatherForecastHourly($weatherForecasts->getWeatherForecast());
                    echo "<tr><td>{$forecast->getTime()}</td><td>{$forecast->getTemperature()}</td><td>{$forecast->getWeather()}</td></tr> " . PHP_EOL;
                    $weatherForecasts->nextForecast();
                }
                echo "</tbody></table> " . PHP_EOL;
                echo "</div><div id='end'><footer>The data was updated at {$weatherForecasts->getForecastTime()} local time</footer></div> " . PHP_EOL;
            }
            break;
    }
}