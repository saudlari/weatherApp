<?php
require_once __DIR__ . '/../src/Weather/WeatherService.php';

class WeatherController {
    public function index()
    {
        $city = $_GET['cidade'] ?? DEFAULT_CITY;
        $weatherService = new WeatherService();
        $weatherData = [];

        if (!empty($city) && $city !== DEFAULT_CITY) {
            $weatherData = $weatherService->getCurrentWeather($city);
        } elseif (isset($_GET['cidade'])) {
            $weatherData = ['error' => true, 'message' => 'Por favor, escreva o nome de uma cidade'];
        }

        // Pasar datos listos a la vista (plantilla)
        require __DIR__ . '/../views/weather.php';
    }
}
