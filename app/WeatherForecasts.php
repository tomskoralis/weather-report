<?php

namespace App;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\{WeatherForecast, Forecast, Exception as OWMException};
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Factory\Guzzle\RequestFactory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class WeatherForecasts
{
    private WeatherForecast $forecasts;

    public function __construct(string $location, int $days, string $units = UNITS, string $language = LANGUAGE)
    {
        if ($location !== "") {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();
            $dotenv->required('API_KEY')->notEmpty();
            $apiKey = substr($_ENV['API_KEY'], 0, -1);
            $httpRequestFactory = new RequestFactory();
            $httpClient = GuzzleAdapter::createWithConfig([]);
            $cache = new FilesystemAdapter();
            $owm = new OpenWeatherMap($apiKey, $httpClient, $httpRequestFactory, $cache, CACHE_REFRESH_TIME);
            try {
                $this->forecasts = $owm->getWeatherForecast($location, $units, $language, '', $days);
            } catch (OWMException $e) {
                echo "OpenWeatherMap exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
            } catch (\Exception $e) {
                echo "General exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
            }
        }
    }

    public function getForecastData(): ?WeatherForecast
    {
        return $this->forecasts ?? null;
    }

    public function getCity(): string
    {
        return $this->getForecastData()->city->name;
    }

    public function getCountry(): string
    {
        return $this->getForecastData()->city->country;
    }

    public function getForecastTime(): string
    {
        return $this->getForecastData()->lastUpdate->setTimezone(
            new \DateTimeZone($this->getTimeZone())
        )->format("G:i:s j/m/Y");
    }

    public function getTimeZone(): string
    {
        return $this->getForecastData()->city->timezone->getName();
    }

    public function getWeatherForecast(): ?Forecast
    {
        if ($this->canGetForecast()) {
            return $this->getForecastData()->current();
        }
        return null;
    }

    public function canGetForecast(): bool
    {
        return $this->getForecastData()->valid();
    }

    public function nextForecast(): void
    {
        $this->getForecastData()->next();
    }
}