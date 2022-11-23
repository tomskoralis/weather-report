<?php

namespace App;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\{CurrentWeather, WeatherForecast, Exception as OWMException};
use Dotenv\Dotenv;
use Dotenv\Exception\ValidationException;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Factory\Guzzle\RequestFactory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

function initialiseOpenWeatherMap(): ?OpenWeatherMap
{
    $dotenv = Dotenv::createImmutable(__DIR__, '../.env');
    $dotenv->load();
    try {
        $dotenv->required('API_KEY')->notEmpty();
    } catch (ValidationException $e) {
        echo "Validation exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
        return null;
    } catch (\Exception $e) {
        echo "General exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
        return null;
    }
    $apiKey = $_ENV['API_KEY'];
    $httpRequestFactory = new RequestFactory();
    $httpClient = GuzzleAdapter::createWithConfig([]);
    $cache = new FilesystemAdapter();
    try {
        return new OpenWeatherMap($apiKey, $httpClient, $httpRequestFactory, $cache, CACHE_REFRESH_TIME);
    } catch (\InvalidArgumentException $e) {
        echo "InvalidArgument exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
    } catch (\Exception $e) {
        echo "General exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
    }
    return null;
}

function fetchCurrentWeather(OpenWeatherMap $owm, string $location, string $units = UNITS, string $language = LANGUAGE): ?CurrentWeather
{
    try {
        return $owm->getWeather($location, $units, $language);
    } catch (OWMException $e) {
        echo "OpenWeatherMap exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
    } catch (\Exception $e) {
        echo "General exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
    }
    return null;
}

function fetchWeatherForecasts(OpenWeatherMap $owm, string $location, int $days, string $units = UNITS, string $language = LANGUAGE): ?WeatherForecast
{
    try {
        return $owm->getWeatherForecast($location, $units, $language, '', $days);
    } catch (OWMException $e) {
        echo "OpenWeatherMap exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
    } catch (\Exception $e) {
        echo "General exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
    }
    return null;
}
