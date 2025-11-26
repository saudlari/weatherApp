<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App del Clima</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-300 via-indigo-200 to-purple-200 flex items-center justify-center">
  <div class="w-full max-w-xl mx-auto p-6">
    <div class="bg-white/80 rounded-2xl shadow-lg px-6 py-8">
      <h1 class="text-3xl font-bold text-indigo-800 mb-6 text-center flex items-center gap-2 justify-center">🌤️ App del Clima</h1>

      <form method="GET" class="flex gap-2 mb-4">
        <input
          type="text" name="cidade" id="cidade"
          placeholder="Ej: Madrid, São Paulo, Nueva York…"
          value="<?= htmlspecialchars($city) ?>" required
          class="flex-1 px-4 py-2 rounded-xl border border-indigo-200 focus:ring-2 focus:ring-indigo-400 focus:outline-none bg-white/90 text-indigo-900 placeholder:text-indigo-400"
        >
        <button type="submit" class="px-5 py-2 text-white font-medium rounded-xl bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">Buscar</button>
        <button type="button" onclick="getLocation(event)" title="Usar mi ubicación actual"
          class="px-4 py-2 bg-sky-300 hover:bg-sky-400 text-sky-900 font-bold rounded-xl focus:ring-2 focus:ring-sky-400 transition"
        >📍</button>
      </form>

      <div class="text-sm text-indigo-700 mb-1 text-center">Buscar por ciudad o pulsa <b>📍</b> para clima cerca de ti</div>

      <div id="favRoot" class="mt-2"></div>

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
        <div class="flex justify-end mb-2">
          <button type="button" onclick="addFavorite('<?= $cidade_nome ?>')"
            class="fav-btn load inline-flex items-center px-3 py-1.5 rounded-xl font-semibold text-yellow-900 bg-yellow-200 hover:bg-yellow-300 border border-transparent shadow-sm transition" title="Guardar ciudad en favoritos">⭐ Añadir <?= $cidade_nome ?>
          </button>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md text-center mb-3">
          <div class="flex items-center justify-center gap-2 text-2xl font-semibold mb-2">
            <span>📍<?= $cidade_nome; ?></span><?php if ($pais): ?><span class="text-lg text-gray-500">, <?= $pais; ?></span><?php endif; ?>
          </div>
          <div class="flex items-center gap-4 justify-center mb-2">
            <img src="http://openweathermap.org/img/wn/<?= $icon; ?>@2x.png" alt="<?= $descricao; ?>" class="w-20 h-20">
            <div class="text-6xl font-bold text-indigo-800"><?= $temp; ?>°C</div>
          </div>
          <div class="capitalize text-indigo-700 mb-3 text-lg"><?= ucfirst($descricao); ?></div>
          <div class="grid grid-cols-2 gap-4 mx-auto max-w-xs">
            <div class="bg-indigo-50 rounded-lg p-2 text-sm flex items-center gap-2"><span class="emoji">💧</span> Umidade: <b><?= $umidade; ?>%</b></div>
            <div class="bg-indigo-50 rounded-lg p-2 text-sm flex items-center gap-2"><span class="emoji">💨</span> Viento: <b><?= $vento; ?> m/s</b></div>
            <div class="bg-indigo-50 rounded-lg p-2 text-sm flex items-center gap-2"><span class="emoji">🌡️</span> Sensación: <b><?= $sensacao; ?>°C</b></div>
            <div class="bg-indigo-50 rounded-lg p-2 text-sm flex items-center gap-2"><span class="emoji">📊</span> Presión: <b><?= $pressao; ?> hPa</b></div>
          </div>
        </div>
      <?php elseif ($hasError): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-center mt-6">
          <p class="font-semibold">
            ❌ <?= htmlspecialchars($weatherData['message'] ?? 'Não foi possível obter o clima'); ?>
          </p>
          <?php if (empty(WEATHER_API_KEY) || WEATHER_API_KEY === 'SUA_CHAVE_API_AQUI'): ?>
            <p class="mt-2 text-xs font-mono px-4 py-1.5 bg-red-200 rounded">
              ⚠️ Configura tu clave API en <code>config/config.local.php</code>
            </p>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <div class="bg-indigo-50 text-indigo-700 text-center rounded-xl p-8 mt-4">
          <p class="text-lg font-medium">👆 Ingresa el nombre de una ciudad y pulsa "Buscar",<br> o pulsa <span class="inline-block">📍</span> para tu ubicación, o selecciona una favorita.</p>
        </div>
      <?php endif; ?>
    </div>
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
    root.innerHTML = '<div class="opacity-60 italic text-center">Sin favoritos aún</div>';
    return;
  }
  root.innerHTML = '<div class="font-semibold text-indigo-900 mb-1">Tus ciudades favoritas:</div>' + favs.map(c => `
    <div class="flex items-center gap-2 mb-1 justify-between bg-sky-100/60 rounded px-3 py-2">
      <span class="grow font-medium text-sky-900 inline-flex items-center">🌍 ${c}</span>
      <button class="fav-btn load bg-indigo-400 hover:bg-indigo-600 text-white px-2 py-1 rounded transition" onclick="loadFavorite('${c.replace(/'/g, "\\'")}')" title="Ver clima de ${c}">Ver</button>
      <button class="fav-btn del bg-red-200 hover:bg-red-400 text-red-700 px-2 py-1 rounded transition" onclick="deleteFavorite('${c.replace(/'/g, "\\'")}')" title="Borrar ${c}">🗑️</button>
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
