<?php

namespace App;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\{CurrentWeather, WeatherForecast, Exception as OWMException};
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

function fetchCurrentWeather(string $location, string $units = "metric", string $language = "en"): ?CurrentWeather
{
    $httpRequestFactory = new RequestFactory();
    $httpClient = GuzzleAdapter::createWithConfig([]);
    $cache = new FilesystemAdapter();
    $owm = new OpenWeatherMap(API_KEY, $httpClient, $httpRequestFactory, $cache);
    try {
        $weather = $owm->getWeather($location, $units, $language);
    } catch (OWMException $e) {
        echo "OpenWeatherMap exception: {$e->getMessage()} (Code {$e->getCode()}).\n";
        return null;
    } catch (\Exception $e) {
        echo "General exception: {$e->getMessage()} (Code {$e->getCode()}).\n";
        return null;
    }
    return $weather;
}

function fetchWeatherForecast(string $location, int $days, string $units = "metric", string $language = "en"): ?WeatherForecast
{
    $httpRequestFactory = new RequestFactory();
    $httpClient = GuzzleAdapter::createWithConfig([]);
    $cache = new FilesystemAdapter();
    $owm = new OpenWeatherMap(API_KEY, $httpClient, $httpRequestFactory, $cache);
    try {
        $weather = $owm->getWeatherForecast($location, $units, $language, '', $days);
    } catch (OWMException $e) {
        echo "OpenWeatherMap exception: {$e->getMessage()} (Code {$e->getCode()}).\n";
        return null;
    } catch (\Exception $e) {
        echo "General exception: {$e->getMessage()} (Code {$e->getCode()}).\n";
        return null;
    }
    return $weather;
}

function displayWeatherCurrentReport(WeatherData $weatherData): void
{
    echo "\nDisplaying current weather for {$weatherData->getCity()}, {$weatherData->getCountry()}\n";
    echo "Average temperature: {$weatherData->getTemperature()}\n";
    if (
        $weatherData->getTemperatureMin() !== $weatherData->getTemperature() &&
        $weatherData->getTemperatureMax() !== $weatherData->getTemperature()
    ) {
        echo "Temperature varies between {$weatherData->getTemperatureMin()} and {$weatherData->getTemperatureMax()}\n";
    }
    echo "Weather: {$weatherData->getWeather()}\n";
    echo "Precipitation: {$weatherData->getPrecipitation()}\n";
    echo "Humidity: {$weatherData->getHumidity()}\n";
    echo "Wind: {$weatherData->getWindSpeed()} from {$weatherData->getWindDirection()}\n";
    echo "The data was gathered at {$weatherData->getTime()} local time\n";
}

function displayWeatherForecastReport(AllForecastData $weatherData, int $days): void
{
    echo "\nDisplaying the weather forecast for {$weatherData->getCity()}, {$weatherData->getCountry()} for the next $days days\n";
    while ($weatherData->canGetForecast()) {
        $forecast = new ForecastData($weatherData->getWeatherForecast());
        echo "{$forecast->getTime()} {$forecast->getTemperature()} {$forecast->getWeather()}\n";
        $weatherData->nextForecast();
    }
    echo "The data was updated at {$weatherData->getForecastTime()} local time\n";
}