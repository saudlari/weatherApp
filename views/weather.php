<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App do Clima</title>
    <link rel="stylesheet" href="public/css/style.css">
    <style>
      .fav-list {margin-top:16px; border-top:1px solid #eee; padding-top: 12px;}
      .fav-btn {margin-left:4px; margin-right:4px; padding:2px 6px; border-radius:6px; border:none; cursor:pointer; background:#eee;}
      .fav-btn.del {background:#ffc0c0; color:#a00;}
      .fav-btn.load {background:#cceaea; color:#187;}
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>🌤️ App do Clima</h1>
        <form method="GET" class="search-form" style="display:flex; gap:8px;">
            <input 
                type="text" name="cidade" id="cidade"
                placeholder="Ej: Madrid, São Paulo, Nueva York…" 
                value="<?= htmlspecialchars($city) ?>" required>
            <button type="submit">Buscar</button>
            <button type="button" onclick="getLocation(event)" title="Usar mi ubicación actual" style="min-width:44px;">📍</button>
        </form>
        <div style="font-size:0.9em; opacity:0.75; margin-top:0.2em;">
            <span>Buscar por ciudad o pulsa <b>📍</b> para ver el clima cerca de ti</span>
        </div>
        <div id="favRoot" class="fav-list"></div>

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
            <div style="text-align:right; margin-top:5px; margin-bottom:10px;">
              <button type="button" onclick="addFavorite('<?= $cidade_nome ?>')" class="fav-btn load" title="Guardar ciudad en favoritos">
                ⭐ Añadir <?= $cidade_nome ?> a favoritos
              </button>
            </div>
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
                        <small>⚠️ Você precisa configurar sua chave API no archivo <code>config/config.local.php</code></small>
                    </p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="inicio">
                <p>👆 Digite el nombre de una ciudad y presione "Buscar",<br> o pulse 📍 para usar tu ubicación.<br> O selecciona una favorita de la lista.</p>
            </div>
        <?php endif; ?>
    </div>
    <script>
    const FAV_KEY = 'weather_favorites';
    function getFavorites() {
      try {
        return JSON.parse(localStorage.getItem(FAV_KEY)) || [];
      } catch {return []}
    }
    function setFavorites(favs) {
      localStorage.setItem(FAV_KEY, JSON.stringify(favs));
      renderFavorites();
    }
    function addFavorite(city) {
      if (!city) return;
      let favs = getFavorites();
      city = city.trim();
      if (city && !favs.includes(city)) favs.push(city);
      setFavorites(favs);
    }
    function loadFavorite(city) {
      if (!city) return;
      window.location.href = '?cidade=' + encodeURIComponent(city);
    }
    function deleteFavorite(city) {
      let favs = getFavorites();
      setFavorites(favs.filter(c => c !== city));
    }
    function renderFavorites() {
      const favs = getFavorites();
      const root = document.getElementById('favRoot');
      if (!root) return;
      if (!favs.length) {
        root.innerHTML = '<div style="opacity:0.65;">No hay ciudades favoritas guardadas.</div>';
        return;
      }
      root.innerHTML = '<b>Tus ciudades favoritas:</b>' + favs.map(c => `
        <div style="margin:3px 0;">
          <button class="fav-btn load" onclick="loadFavorite('${c.replace(/'/g, "\\'")}')" title="Ver clima de ${c}">🌍 ${c}</button>
          <button class="fav-btn del" onclick="deleteFavorite('${c.replace(/'/g, "\\'")}')" title="Borrar ${c}">🗑️</button>
        </div>
      `).join('');
    }
    renderFavorites();
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
