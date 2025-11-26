<?php
require_once __DIR__ . '/../src/Weather/WeatherService.php';

class WeatherController {
    public function index() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $fav_cities = $_SESSION['fav_cities'] ?? [];
        $lang = $_GET['lang'] ?? 'en';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['add_fav'])) {
                $ciudad_fav = mb_strtolower(trim($_POST['add_fav']));
                if ($ciudad_fav && !in_array($ciudad_fav, array_map('mb_strtolower',$fav_cities))) {
                    $fav_cities[] = $_POST['add_fav']; // guarda como lo escribió el usuario
                }
                $_SESSION['fav_cities'] = $fav_cities;
            }
            if (!empty($_POST['del_fav'])) {
                $fav_cities = array_filter($fav_cities, function($c) {
                    return mb_strtolower($c) !== mb_strtolower($_POST['del_fav']);
                });
                $_SESSION['fav_cities'] = $fav_cities;
            }
            if (!empty($_POST['clear_favs'])) {
                $fav_cities = [];
                $_SESSION['fav_cities'] = $fav_cities;
            }
        }
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
            $weatherData = ['error' => true, 'message' => 'Por favor, escriba el nombre de una ciudad'];
        }
        require __DIR__ . '/../views/weather.php';
    }
}
