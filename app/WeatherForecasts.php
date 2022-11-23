<?php

namespace App;

use Cmfcmf\OpenWeatherMap\{WeatherForecast, Forecast};

class WeatherForecasts
{
    private WeatherForecast $forecasts;

    public function __construct(WeatherForecast $forecasts)
    {
        $this->forecasts = $forecasts;
    }

    private function getWeatherData(): ?WeatherForecast
    {
        return $this->forecasts ?? null;
    }

    public function getCity(): string
    {
        return $this->getWeatherData()->city->name;
    }

    public function getCountry(): string
    {
        return $this->getWeatherData()->city->country;
    }

    public function getTime(): string
    {
        return $this->getWeatherData()->lastUpdate->setTimezone(
            new \DateTimeZone($this->getTimeZone())
        )->format("G:i:s j/m/Y");
    }

    public function getTimeZone(): string
    {
        return $this->getWeatherData()->city->timezone->getName();
    }

    public function getWeatherForecast(): ?Forecast
    {
        if ($this->canGetForecast()) {
            return $this->getWeatherData()->current();
        }
        return null;
    }

    public function canGetForecast(): bool
    {
        return $this->getWeatherData()->valid();
    }

    public function nextForecast(): void
    {
        $this->getWeatherData()->next();
    }
}