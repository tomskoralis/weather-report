<?php

namespace App;

class Application
{
    public static function renderView(string $view, array $variables): ?array
    {
        if(count($variables))
        {
            extract($variables);
        }
        $location = $_GET["location"] ?? "Riga";
        $OpenWeatherMap = initialiseOpenWeatherMap();
        require_once "views/" . $view . ".php";
        return $variables;
    }
}