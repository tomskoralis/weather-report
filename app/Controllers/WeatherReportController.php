<?php

namespace App\Controllers;

use App\Application;

require_once 'app/constants.php';
require_once 'app/functions.php';

class WeatherReportController
{
    public function index(): array
    {
        $variable = ($_GET["type"] === "current" || $_GET["type"] === "forecast") ? $_GET["type"] : "current";
        return Application::renderView("index", compact('variable'));
    }
}