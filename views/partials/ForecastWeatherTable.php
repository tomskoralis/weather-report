<?php

use Cmfcmf\OpenWeatherMap;
use App\{WeatherForecastHourly, WeatherForecasts};
use function App\fetchWeatherForecasts;
use const App\DAYS;

/** @var OpenWeatherMap $OpenWeatherMap */
/** @var string $location */

$weatherData = fetchWeatherForecasts($OpenWeatherMap, $location, DAYS);
if (isset($weatherData)) {
    $weatherReport = new WeatherForecasts($weatherData);
    ?>
    <p id='tableHeading'><?= DAYS ?> day weather forecast for <?= $weatherReport->getCity() ?>,
        <?= $weatherReport->getCountry() ?></p>
    <table class='forecast'>
        <thead>
        <tr>
            <th>Time</th>
            <th>Temperature</th>
            <th>Weather</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($weatherReport->canGetForecast()) {
            $forecast = new WeatherForecastHourly($weatherReport->getWeatherForecast());
            ?>
            <tr>
                <td><?= $forecast->getForecastTime() ?></td>
                <td><?= $forecast->getTemperature() ?></td>
                <td>
                    <img class="weatherIcon"
                         src='https://openweathermap.org/img/wn/<?= $forecast->getWeatherSymbol() ?>.png'
                         alt='<?= $forecast->getWeatherSymbol() ?>'>
                    <?= $forecast->getWeather() ?>
                </td>
            </tr>
            <?php
            $weatherReport->nextForecast();
        }
        ?>
        </tbody>
    </table>
    <?php
} ?>