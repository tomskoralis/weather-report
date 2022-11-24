<?php

namespace App\Controllers;

use App\Application;

class WeatherReportController
{
    public function index(Application $application): array
    {
        $type = ($_GET["type"] === "current" || $_GET["type"] === "forecast") ? $_GET["type"] : "current";
        $location = $_GET["location"] ?? "Riga";
        $openWeatherMap = $application->getOpenWeatherMap();
        return Application::renderView("index", compact('type', 'location', 'openWeatherMap'));
    }
}