<?php

namespace App;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\{CurrentWeather, Exception as OWMException};
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Factory\Guzzle\RequestFactory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class WeatherCurrently
{
    private CurrentWeather $weatherData;

    public function __construct(string $location, string $units = UNITS, string $language = LANGUAGE)
    {
        if ($location !== "") {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__, '../.env');
            $dotenv->load();
            $dotenv->required('API_KEY' )->notEmpty();
            $apiKey = substr($_ENV['API_KEY'], 0, -1);
            $httpRequestFactory = new RequestFactory();
            $httpClient = GuzzleAdapter::createWithConfig([]);
            $cache = new FilesystemAdapter();
            $owm = new OpenWeatherMap($apiKey, $httpClient, $httpRequestFactory, $cache, CACHE_REFRESH_TIME);
            try {
                $this->weatherData = $owm->getWeather($location, $units, $language);
            } catch (OWMException $e) {
                echo "OpenWeatherMap exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
            } catch (\Exception $e) {
                echo "General exception: {$e->getMessage()} (Code {$e->getCode()})" . LINE_BREAK;
            }
        }
    }

    public function getWeatherData(): ?CurrentWeather
    {
        return $this->weatherData ?? null;
    }

    public function getCity(): string
    {
        return $this->getWeatherData()->city->name;
    }

    public function getCountry(): string
    {
        return $this->getWeatherData()->city->country;
    }

    public function getTimeZone(): string
    {
        return $this->getWeatherData()->city->timezone->getName();
    }

    public function getTime(): string
    {
        return $this->getWeatherData()->lastUpdate->setTimezone(
            new \DateTimeZone($this->getTimeZone())
        )->format("G:i:s j/m/Y");
    }

    public function getTemperature(): string
    {
        return $this->getWeatherData()->temperature->getFormatted();
    }

    public function getTemperatureMin(): string
    {
        return $this->getWeatherData()->temperature->min->getFormatted();
    }

    public function getTemperatureMax(): string
    {
        return $this->getWeatherData()->temperature->max->getFormatted();
    }

    public function getHumidity(): string
    {
        return $this->getWeatherData()->humidity->getFormatted();
    }

    public function getWindSpeed(): string
    {
        return $this->getWeatherData()->wind->speed->getFormatted();
    }

    public function getWindDirection(): string
    {
        return $this->getWeatherData()->wind->direction->getUnit();
    }

    public function getWeather(): string
    {
        return $this->getWeatherData()->weather->description;
    }

    public function getPrecipitation(): string
    {
        return $this->getWeatherData()->precipitation->getDescription();
    }
}