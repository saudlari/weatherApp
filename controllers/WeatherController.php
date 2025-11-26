<?php
require_once __DIR__ . '/../src/Weather/WeatherService.php';

class WeatherController {
    public function index() {
        $lang = $_GET['lang'] ?? 'en';
        $weatherService = new WeatherService($lang);
        $weatherData = [];
        $city = trim($_GET['cidade'] ?? '');
        if (!empty($_GET['lat']) && !empty($_GET['lon'])) {
            $lat = $_GET['lat'];
            $lon = $_GET['lon'];
            $weatherData = $weatherService->getCurrentWeatherByCoordinates($lat, $lon);
            if (isset($weatherData['name'])) {
                $city = $weatherData['name'];
            }
        } elseif ($city !== '') {
            $weatherData = $weatherService->getCurrentWeather($city);
        } elseif (isset($_GET['cidade'])) {
            $weatherData = ['error' => true, 'message' => 'Por favor, escreva o nome de uma cidade'];
        }
        require __DIR__ . '/../views/weather.php';
    }
}
