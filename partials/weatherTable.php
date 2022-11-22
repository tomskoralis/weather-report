<?php

require_once 'app/constants.php';

use App\{WeatherCurrently, WeatherForecastHourly, WeatherForecasts};
use const App\{DAYS};

if (isset($_GET["type"])) {
    switch ($_GET["type"]) {
        case "current":
            $currentWeather = new WeatherCurrently($_GET["location"]);
            if ($currentWeather->getWeatherData() !== null) {
                echo "<table class='current'>";
                echo "<thead><tr><th colspan='2'>Current weather for {$currentWeather->getCity()}, {$currentWeather->getCountry()}</th></tr></thead>";
                echo "<tbody><tr><td>Temperature:</td><td>{$currentWeather->getTemperature()}</td></tr>";
                if (
                    $currentWeather->getTemperatureMin() !== $currentWeather->getTemperature() &&
                    $currentWeather->getTemperatureMax() !== $currentWeather->getTemperature()
                ) {
                    echo "<tr><td></td><td>{$currentWeather->getTemperatureMin()} ~ {$currentWeather->getTemperatureMax()}</td></tr>";
                }
                echo "<tr><td>Weather:</td><td>{$currentWeather->getWeather()}</td></tr>";
                echo "<tr><td>Precipitation:</td><td>{$currentWeather->getPrecipitation()}</td></tr>";
                echo "<tr><td>Humidity:</td><td>{$currentWeather->getHumidity()}</td></tr>";
                echo "<tr><td>Wind:</td><td>{$currentWeather->getWindSpeed()} from {$currentWeather->getWindDirection()}</td></tr>";
                echo "</tbody></table>";
                echo "</div><div id='end'><footer>The data was updated at {$currentWeather->getTime()} local time</footer></div>";
            }
            break;
        case "forecast":
            $weatherForecasts = new WeatherForecasts($_GET["location"], DAYS);
            if ($weatherForecasts->getForecastData() !== null) {
                echo "<table class='forecast'>";
                echo "<thead><tr><th colspan='4'>" . DAYS . " day weather forecast for {$weatherForecasts->getCity()}, {$weatherForecasts->getCountry()}</th></tr>";
                echo "<tr><th>Time</th><th>Temperature</th><th>Weather</th></tr></thead>";
                echo "<tbody>";
                while ($weatherForecasts->canGetForecast()) {
                    $forecast = new WeatherForecastHourly($weatherForecasts->getWeatherForecast());
                    echo "<tr><td>{$forecast->getTime()}</td><td>{$forecast->getTemperature()}</td><td>{$forecast->getWeather()}</td></tr>";
                    $weatherForecasts->nextForecast();
                }
                echo "</tbody></table>";
                echo "</div><div id='end'><footer>The data was updated at {$weatherForecasts->getForecastTime()} local time</footer></div>";
            }
            break;
    }
}