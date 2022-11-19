<?php

require_once 'vendor/autoload.php';
require_once 'app/functions.php';
require_once 'app/API_KEY.php';

use App\{WeatherData, AllForecastData};
use function App\{
    fetchCurrentWeather,
    displayWeatherCurrentReport,
    fetchWeatherForecast,
    displayWeatherForecastReport
};

echo "Weather API\n";
echo "1. Display current weather\n";
echo "2. Display weather forecast\n";
echo "0. Exit\n";
$selection = (int)readline("Input number (0-2): ");

switch ($selection) {
    case 1:
        $city = readline("Input location: ");
        $weatherData = fetchCurrentWeather($city);
        if (isset($weatherData)) {
            $weatherData = new WeatherData($weatherData);
            displayWeatherCurrentReport($weatherData);
        } else {
            echo "Couldn't gather the weather data!\n";
        }
        break;
    case 2:
        $city = readline("Input location: ");
        do {
            $days = (int)readline("Input forecast length in days (1-5): ");
        } while ($days < 1 || $days > 5);
        $weatherForecastData = fetchWeatherForecast($city, $days);
        if (isset($weatherForecastData)) {
            $weatherForecastData = new AllForecastData($weatherForecastData);
            displayWeatherForecastReport($weatherForecastData, $days);
        } else {
            echo "Couldn't gather the weather data!\n";
        }
        break;
    default:
}