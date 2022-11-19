<?php

namespace App;

use Cmfcmf\OpenWeatherMap\Forecast;

class ForecastData
{
    private Forecast $forecast;

    public function __construct(Forecast $forecast)
    {
        $this->forecast = $forecast;
    }

    private function getForecast(): ?Forecast
    {
        return $this->forecast;
    }

    public function getTimeZone(): string
    {
        return $this->getForecast()->city->timezone->getName();
    }

    public function getTime(): string
    {
        return $this->getForecast()->time->from->setTimezone(
            new \DateTimeZone($this->getTimeZone())
        )->format("D j/m H:i");
    }

    public function getTemperature(): string
    {
        return $this->getForecast()->temperature->getFormatted();
    }

    public function getWeather(): string
    {
        return $this->getForecast()->weather->description;
    }
}