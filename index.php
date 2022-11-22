<?php

require_once 'vendor/autoload.php';
require_once 'app/constants.php';

use App\{WeatherCurrently, WeatherForecastHourly, WeatherForecasts};
use const App\{DAYS};

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>&#9748Weather Report</title>
</head>
<link rel="stylesheet" href="app/style.css">
<body>
<div id="container">
    <div id="top">
        <header>
            <nav>Select a location:
                <a href="/?location=Riga&type=current">Riga</a> |
                <a href="/?location=Vilnius&type=current">Vilnius</a> |
                <a href="/?location=Tallinn&type=current">Tallinn</a><br>
            </nav>
        </header>
        <br>
        <form action="/" method="get">
            <label for="location">Other location:<br></label>
            <input type="text" name="location" id="location" value="<?= $_GET['location'] ?? "Riga" ?>"> <br>
            <input type="radio"
                   name="type"
                   id="current"
                   value="current"
                <?= ($_GET['type'] !== "forecast") ? "checked" : "" ?>
            >
            <label for="current">current</label>
            <input type="radio"
                   name="type"
                   id="forecast"
                   value="forecast"
                <?= ($_GET['type'] === "forecast") ? "checked" : "" ?>
            >
            <label for="forecast">forecast</label>
            <input type="submit" value="Send">
        </form>
    </div>
    <div id="content">
        <br>
        <?php
        $location = $_GET["location"];
        if (!isset($location) || $location === "") {
            echo '<meta http-equiv="refresh" content="0; url=/?location=Riga&type=current"/>';
        }
        switch ($_GET["type"]) {
            case "current":
                $currentWeather = new WeatherCurrently($location);
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
                $weatherForecasts = new WeatherForecasts($location, DAYS);
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
        ?>
    </div>
</div>
</body>
</html>