<?php

use Cmfcmf\OpenWeatherMap;
use function App\fetchCurrentWeather;
use App\WeatherCurrently;

/** @var OpenWeatherMap $OpenWeatherMap */
/** @var string $location */

$weatherData = fetchCurrentWeather($OpenWeatherMap, $location);
if (isset($weatherData)) {
    $weatherReport = new WeatherCurrently($weatherData);
    ?>
    <p id='tableHeading'> Current weather
        for <?= $weatherReport->getCity() ?>, <?= $weatherReport->getCountry() ?></p>
    <table class='current'>
        <tbody>
        <tr>
            <td>Temperature:</td>
            <td><?= $weatherReport->getTemperature() ?></td>
        </tr>
        <?php if (
            $weatherReport->getTemperatureMin() !== $weatherReport->getTemperature() &&
            $weatherReport->getTemperatureMax() !== $weatherReport->getTemperature()
        ) {
            ?>
            <tr>
                <td></td>
                <td><?= $weatherReport->getTemperatureMin() ?> ~ <?= $weatherReport->getTemperatureMax() ?> </td>
            </tr>
        <?php } ?>
        <tr>
            <td>Weather:</td>
            <td>
                <img class="weatherIcon"
                     src='https://openweathermap.org/img/wn/<?= $weatherReport->getWeatherSymbol() ?>.png'
                     alt='<?= $weatherReport->getWeatherSymbol() ?>'>
                <?= $weatherReport->getWeather() ?>
            </td>
        </tr>
        <tr>
            <td>Precipitation:</td>
            <td><?= $weatherReport->getPrecipitation() ?></td>
        </tr>
        <tr>
            <td>Humidity:</td>
            <td><?= $weatherReport->getHumidity() ?></td>
        </tr>
        <tr>
            <td>Wind:</td>
            <td><?= $weatherReport->getWindSpeed() ?> from <?= $weatherReport->getWindDirection() ?></td>
        </tr>
        </tbody>
    </table>
<?php } ?>