<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App do Clima</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="contenedor">
        <h1>🌤️ App do Clima</h1>
        <form method="GET" class="search-form" style="display:flex; gap:8px;">
            <input 
                type="text" name="cidade" 
                placeholder="Digite uma cidade..." 
                value="<?= htmlspecialchars($city) ?>" required>
            <button type="submit">Buscar</button>
            <button type="button" onclick="getLocation(event)" title="Usar mi ubicación actual" style="min-width:44px;">📍</button>
        </form>

        <?php 
        $hasError = isset($weatherData['error']) && $weatherData['error'];
        $isSuccess = !$hasError && isset($weatherData['cod']) && $weatherData['cod'] == 200;
        ?>
        <?php if ($isSuccess): ?>
            <?php
            $temp = round($weatherData['main']['temp']);
            $cidade_nome = htmlspecialchars($weatherData['name']);
            $pais = htmlspecialchars($weatherData['sys']['country'] ?? '');
            $descricao = htmlspecialchars($weatherData['weather'][0]['description']);
            $icon = $weatherData['weather'][0]['icon'];
            $umidade = $weatherData['main']['humidity'];
            $vento = round($weatherData['wind']['speed'] ?? 0, 1);
            $sensacao = round($weatherData['main']['feels_like']);
            $pressao = $weatherData['main']['pressure'];
            ?>
            <div class="clima">
                <div class="ciudad">
                    📍 <?= $cidade_nome; ?><?= $pais ? ', ' . $pais : ''; ?>
                </div>
                <div class="icono-temperatura">
                    <img src="http://openweathermap.org/img/wn/<?= $icon; ?>@2x.png" alt="<?= $descricao; ?>" class="icono-clima">
                    <div class="temperatura"><?= $temp; ?>°C</div>
                </div>
                <div class="descripcion"><?= ucfirst($descricao); ?></div>
                <div class="detalles">
                    <div class="detalle-item"><span class="emoji">💧</span> <span>Umidade: <?= $umidade; ?>%</span></div>
                    <div class="detalle-item"><span class="emoji">💨</span> <span>Vento: <?= $vento; ?> m/s</span></div>
                    <div class="detalle-item"><span class="emoji">🌡️</span> <span>Sensação: <?= $sensacao; ?>°C</span></div>
                    <div class="detalle-item"><span class="emoji">📊</span> <span>Pressão: <?= $pressao; ?> hPa</span></div>
                </div>
            </div>
        <?php elseif ($hasError): ?>
            <div class="error">
                <p>❌ <?= htmlspecialchars($weatherData['message'] ?? 'Não foi possível obter o clima'); ?></p>
                <?php if (empty(WEATHER_API_KEY) || WEATHER_API_KEY === 'SUA_CHAVE_API_AQUI'): ?>
                    <p class="error-help">
                        <small>⚠️ Você precisa configurar sua chave API no arquivo <code>config/config.local.php</code></small>
                    </p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="inicio">
                <p>👆 Digite o nome de uma cidade acima y presione "Buscar",<br> o pulse 📍 para usar tu ubicación.</p>
            </div>
        <?php endif; ?>
    </div>
    <script>
    function getLocation(evt) {
        evt.preventDefault(); 
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                window.location.href = "?lat=" + lat + "&lon=" + lon;
            }, function(error) {
                alert('No pudimos obtener tu ubicación');
            });
        } else {
            alert('La Geolocalización no está soportada');
        }
    }
    </script>
</body>
</html>
