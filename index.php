<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/WeatherController.php';

dispatch();
function dispatch() {
    $controller = new WeatherController();
    $controller->index();
}
