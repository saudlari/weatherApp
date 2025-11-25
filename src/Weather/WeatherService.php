<?php

class WeatherService
{
    private $apiKey;
    private $baseUrl;
    private $units;
    private $language;

    public function __construct()
    {
        $this->apiKey = defined('WEATHER_API_KEY') ? WEATHER_API_KEY : '';
        $this->baseUrl = defined('WEATHER_API_BASE_URL') ? WEATHER_API_BASE_URL : 'https://api.openweathermap.org/data/2.5/';
        $this->units = defined('DEFAULT_UNITS') ? DEFAULT_UNITS : 'metric';
        $this->language = defined('DEFAULT_LANGUAGE') ? DEFAULT_LANGUAGE : 'pt_br';
    }

    public function getCurrentWeather($cityName)
    {
        if (empty($cityName)) {
            return ['error' => true, 'message' => 'O nome da cidade não pode estar vazio'];
        }

        $params = [
            'q' => $cityName,
            'appid' => $this->apiKey,
            'units' => $this->units,
            'lang' => $this->language
        ];

        return $this->makeRequest('weather', $params);
    }

    private function makeRequest($endpoint, $params = [])
    {
        $url = $this->baseUrl . $endpoint . '?' . http_build_query($params);

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $response = curl_exec($ch);
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);

        if ($error) {
            return ['error' => true, 'message' => 'Erro de conexão: ' . $error];
        }

        if ($httpCode !== 200) {
            $data = json_decode($response, true);
            return [
                'error' => true,
                'message' => $data['message'] ?? 'Erro desconhecido',
                'code' => $httpCode
            ];
        }

        $data = json_decode($response, true);

        if (isset($data['cod']) && $data['cod'] !== 200) {
            return [
                'error' => true,
                'message' => $data['message'] ?? 'Erro na resposta da API',
                'code' => $data['cod']
            ];
        }

        return $data;
    }
}