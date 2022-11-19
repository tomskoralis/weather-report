<?php

namespace App;

use Cmfcmf\OpenWeatherMap\{Forecast, WeatherForecast};

class AllForecastData
{
    private WeatherForecast $forecast;

    public function __construct(WeatherForecast $forecast)
    {
        $this->forecast = $forecast;
    }

    private function getForecastData(): WeatherForecast
    {
        return $this->forecast;
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
        if ($this->getForecastData()->valid()) {
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