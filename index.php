<?php

require_once __DIR__ . '/config/config.php';

require_once __DIR__ . '/src/Weather/WeatherService.php';

require_once __DIR__ . '/views/weather.php';

$cidade = $_GET['cidade'] ?? DEFAULT_CITY;

$weatherService = new WeatherService();

$weatherData = [];
if (!empty($cidade) && $cidade !== DEFAULT_CITY) {
    $weatherData = $weatherService->getCurrentWeather($cidade);
} else if (isset($_GET['cidade'])) {
    $weatherData = ['error' => true, 'message' => 'Por favor, escreva o nome de uma cidade'];
}
renderWeatherView($weatherData, $cidade);
