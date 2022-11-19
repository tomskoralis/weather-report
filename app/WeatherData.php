<?php

namespace App;

use Cmfcmf\OpenWeatherMap\CurrentWeather;

class WeatherData
{
    private CurrentWeather $weatherData;

    public function __construct(CurrentWeather $weatherData)
    {
        $this->weatherData = $weatherData;
    }

    private function getWeatherData(): CurrentWeather
    {
        return $this->weatherData;
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