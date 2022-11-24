<?php

namespace App;

use Cmfcmf\OpenWeatherMap;

class Application
{
    private ?OpenWeatherMap $openWeatherMap;

    public function __construct()
    {
        $this->openWeatherMap = initialiseOpenWeatherMap();
    }

    public function getOpenWeatherMap(): ?OpenWeatherMap
    {
        return $this->openWeatherMap;
    }

    public static function renderView(string $view, array $variables): ?array
    {
        if (count($variables)) {
            extract($variables);
        }
        require_once "views/" . $view . ".php";
        return $variables;
    }
}