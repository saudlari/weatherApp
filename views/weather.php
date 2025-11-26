<!DOCTYPE html>
<html lang="<?= $lang ?? 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App del Clima</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-neutral-100 flex items-center justify-center">
<?php
$lang = $lang ?? ($_GET['lang'] ?? 'en');
$translations = [
  'en' => [
    'app_title' => 'Weather App',
    'search_placeholder' => 'Eg: Madrid, São Paulo, New York…',
    'search_button' => 'Search',
    'location_button' => 'My location',
    'favorites' => 'Your favorite cities',
    'add_favorite' => 'Add',
    'humidity' => 'Humidity',
    'wind' => 'Wind',
    'feels_like' => 'Feels like',
    'pressure' => 'Pressure',
    'city_error' => 'Please enter a city name',
    'location_help' => 'Search by city or tap the location pin for weather nearby.',
    'empty_favs' => 'No favorites yet',
    'see_weather' => 'View',
    'delete' => 'Delete',
    'input_hint' => 'Type a city and press search, or tap the pin for your location, or pick a favorite.',
    'api_key_help' => 'Set your API key in config/config.local.php',
    'unit_temp' => '°C',
    'unit_speed' => 'm/s',
    'unit_pressure' => 'hPa',
    'add_to_favs' => 'Add ',
  ],
  'es' => [
    'app_title' => 'App del Clima',
    'search_placeholder' => 'Ej: Madrid, São Paulo, Nueva York…',
    'search_button' => 'Buscar',
    'location_button' => 'Mi ubicación',
    'favorites' => 'Tus ciudades favoritas',
    'add_favorite' => 'Añadir',
    'humidity' => 'Humedad',
    'wind' => 'Viento',
    'feels_like' => 'Sensación',
    'pressure' => 'Presión',
    'city_error' => 'Por favor, escriba el nombre de una ciudad',
    'location_help' => 'Buscar por ciudad o pulsa el pin para clima cerca de ti.',
    'empty_favs' => 'Sin favoritos aún',
    'see_weather' => 'Ver',
    'delete' => 'Borrar',
    'input_hint' => 'Escribe una ciudad y pulsa buscar, o pulsa el pin para tu ubicación, o selecciona una favorita.',
    'api_key_help' => 'Configura tu clave API en config/config.local.php',
    'unit_temp' => '°C',
    'unit_speed' => 'm/s',
    'unit_pressure' => 'hPa',
    'add_to_favs' => 'Añadir ',
  ],
  'pt_br' => [
    'app_title' => 'App do Clima',
    'search_placeholder' => 'Ex: Madrid, São Paulo, Nova York…',
    'search_button' => 'Buscar',
    'location_button' => 'Minha localização',
    'favorites' => 'Cidades favoritas',
    'add_favorite' => 'Adicionar',
    'humidity' => 'Umidade',
    'wind' => 'Vento',
    'feels_like' => 'Sensação',
    'pressure' => 'Pressão',
    'city_error' => 'Por favor, digite o nome de uma cidade',
    'location_help' => 'Busque por cidade ou clique no pin para clima perto de você.',
    'empty_favs' => 'Sem favoritos',
    'see_weather' => 'Ver',
    'delete' => 'Excluir',
    'input_hint' => 'Digite uma cidade e busque, ou clique no pin para sua localização, ou escolha um favorito.',
    'api_key_help' => 'Configure sua chave API em config/config.local.php',
    'unit_temp' => '°C',
    'unit_speed' => 'm/s',
    'unit_pressure' => 'hPa',
    'add_to_favs' => 'Adicionar ',
  ],
];
$t = $translations[$lang] ?? $translations['en'];
?>
  <div class="w-full max-w-xl mx-auto p-6">
    <div class="mb-4 flex justify-start">
      <form method="GET" class="flex gap-1 items-center">
        <select name="lang" id="lang" onchange="this.form.submit()"
          class="rounded-lg border border-neutral-300 px-3 py-1 bg-neutral-50 text-neutral-900 shadow-sm">
          <option value="en"<?= $lang==='en'?' selected':''; ?>>English</option>
          <option value="es"<?= $lang==='es'?' selected':''; ?>>Español</option>
          <option value="pt_br"<?= $lang==='pt_br'?' selected':''; ?>>Português</option>
        </select>
        <input type="hidden" name="cidade" value="<?= htmlspecialchars($city ?? '') ?>">
      </form>
    </div>
    <div class="bg-white rounded-xl shadow-md px-6 py-8 border border-neutral-200">
      <div class="flex flex-col md:flex-row justify-between items-center mb-2 gap-2">
        <h1 class="text-3xl font-bold text-neutral-900 text-center flex items-center gap-2 justify-center">
          <svg class="inline w-8 h-8 text-yellow-400 align-top mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5" fill="#facc15" stroke="none"/><path d="M12 1v2M12 21v2M21 12h2M1 12H3M16.95 7.05l1.414-1.414M4.636 19.364l1.414-1.414M5.05 7.05 3.636 5.636M19.364 19.364l-1.414-1.414" stroke="#d97706" stroke-linecap="round"/></svg>
          <?= $t['app_title'] ?>
        </h1>
      </div>
      <form method="GET" class="flex gap-2 mb-4">
        <input
          type="hidden" name="lang" value="<?= $lang ?>">
        <input
          type="text" name="cidade" id="cidade"
          placeholder="<?= $t['search_placeholder'] ?>"
          value="<?= htmlspecialchars($city) ?>" required
          class="flex-1 px-4 py-2 rounded-lg border border-neutral-300 focus:ring-2 focus:ring-neutral-400 focus:outline-none bg-neutral-50 text-neutral-900 placeholder:text-neutral-400"
        >
        <button type="submit" class="px-5 py-2 text-white font-medium rounded-lg bg-neutral-900 hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-neutral-400 transition"><?= $t['search_button'] ?></button>
        <button type="button" onclick="getLocation(event)" title="<?= $t['location_button'] ?>"
          class="px-4 py-2 bg-neutral-200 hover:bg-neutral-300 text-neutral-700 font-bold rounded-lg focus:ring-2 focus:ring-neutral-400 transition border border-neutral-300 flex items-center justify-center"
        >
          <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-3.866-3.868-7-7.22-7-11A7 7 0 0112 3a7 7 0 017 7c0 3.78-3.134 7.132-7 11z" /><circle cx="12" cy="10" r="3" /></svg>
        </button>
      </form>
      <div class="text-sm text-neutral-600 mb-2 text-center"><?= $t['location_help'] ?></div>
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
            class="inline-flex items-center px-3 py-1.5 rounded-lg font-semibold text-neutral-900 bg-neutral-200 hover:bg-neutral-300 border border-neutral-300 transition" title="<?= $t['add_favorite'] ?>">
            <svg class="w-5 h-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.97c.3.922-.755 1.688-1.538 1.118l-3.385-2.46a1 1 0 00-1.175 0l-3.385 2.46c-.783.57-1.838-.196-1.539-1.118l1.287-3.97A1 1 0 004.01 9.857l-3.385-2.46c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z"/></svg>
            <?= $t['add_to_favs'] . $cidade_nome ?>
          </button>
        </div>
        <div class="bg-neutral-50 rounded-lg p-6 shadow-sm text-center mb-3 border border-neutral-200">
          <div class="flex items-center justify-center gap-2 text-2xl font-semibold mb-2 text-neutral-800">
            <svg class="w-6 h-6 text-neutral-400 mr-1 inline-block align-middle" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-3.866-3.868-7-7.22-7-11A7 7 0 0112 3a7 7 0 017 7c0 3.78-3.134 7.132-7 11z" /><circle cx="12" cy="10" r="3" /></svg>
            <span><?= $cidade_nome; ?></span><?php if ($pais): ?><span class="text-lg text-neutral-400">, <?= $pais; ?></span><?php endif; ?>
          </div>
          <div class="flex items-center gap-4 justify-center mb-2">
            <img src="http://openweathermap.org/img/wn/<?= $icon; ?>@2x.png" alt="<?= $descricao; ?>" class="w-20 h-20">
            <div class="text-6xl font-bold text-neutral-900"><?= $temp . $t['unit_temp']; ?></div>
          </div>
          <div class="capitalize text-neutral-500 mb-3 text-lg tracking-wide"><?= ucfirst($descricao); ?></div>
          <div class="grid grid-cols-2 gap-4 mx-auto max-w-xs">
            <div class="bg-white border rounded-lg px-2 py-1 text-sm flex items-center gap-2 text-neutral-600">
              <svg width="20" height="20" fill="none" stroke="currentColor" class="inline mx-1 text-sky-500" viewBox="0 0 24 24"><path stroke-width="2" d="M12 3.25C12 3.25 6.25 10 6.25 14A5.75 5.75 0 1 0 18.75 14C18.75 10 12 3.25 12 3.25Z"/></svg>
              <?= $t['humidity'] ?>: <b class="ml-1 text-neutral-900"><?= $umidade; ?>%</b>
            </div>
            <div class="bg-white border rounded-lg px-2 py-1 text-sm flex items-center gap-2 text-neutral-600">
              <svg width="20" height="20" fill="none" stroke="currentColor" class="inline mx-1 text-gray-400" viewBox="0 0 24 24"><path stroke-width="2" d="M17 8C18.6569 8 20 9.34315 20 11C20 12.6569 18.6569 14 17 14H2M7 14H11M7 14C5.34315 14 4 12.6569 4 11C4 9.34315 5.34315 8 7 8C8.65685 8 10 9.34315 10 11C10 12.6569 11.34315 14 13 14H15"/></svg>
              <?= $t['wind'] ?>: <b class="ml-1 text-neutral-900"><?= $vento; ?> <?= $t['unit_speed'] ?></b>
            </div>
            <div class="bg-white border rounded-lg px-2 py-1 text-sm flex items-center gap-2 text-neutral-600">
              <svg width="20" height="20" fill="none" stroke="currentColor" class="inline mx-1 text-pink-400" viewBox="0 0 24 24"><circle cx="12" cy="17" r="5" stroke-width="2"/><path stroke-width="2" d="M12 17V5"/><circle cx="12" cy="5" r="2" stroke-width="2"/></svg>
              <?= $t['feels_like'] ?>: <b class="ml-1 text-neutral-900"><?= $sensacao . $t['unit_temp']; ?></b>
            </div>
            <div class="bg-white border rounded-lg px-2 py-1 text-sm flex items-center gap-2 text-neutral-600">
              <svg width="20" height="20" fill="none" stroke="currentColor" class="inline mx-1 text-indigo-500" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-width="2" d="M12 7v5l3 3"/></svg>
              <?= $t['pressure'] ?>: <b class="ml-1 text-neutral-900"><?= $pressao . ' ' . $t['unit_pressure']; ?></b>
            </div>
          </div>
        </div>
      <?php elseif ($hasError): ?>
        <div class="bg-neutral-200 border border-neutral-400 text-neutral-700 px-4 py-3 rounded-lg text-center mt-6">
          <p class="font-semibold">❌ <?= htmlspecialchars($weatherData['message'] ?? $t['city_error']); ?></p>
          <?php if (empty(WEATHER_API_KEY) || WEATHER_API_KEY === 'SUA_CHAVE_API_AQUI'): ?>
            <p class="mt-2 text-xs font-mono px-4 py-1.5 bg-neutral-300 rounded">⚠️ <?= $t['api_key_help'] ?></p>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <div class="bg-neutral-50 border border-neutral-200 text-neutral-600 text-center rounded-lg p-8 mt-4">
          <p class="text-lg font-medium">👆 <?= $t['input_hint'] ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
<script>
const FAV_KEY = 'weather_favorites';
let urlLang = '<?= $lang ?>';
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
  let params = new URLSearchParams(window.location.search);
  params.set('cidade', city);
  params.set('lang', urlLang);
  window.location.search = params.toString();
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
    root.innerHTML = `<div class="opacity-60 italic text-center">${<?= json_encode($t['empty_favs']) ?>}</div>`;
    return;
  }
  root.innerHTML = `<div class="font-semibold text-neutral-800 mb-1">${<?= json_encode($t['favorites']) ?>}:</div>` + favs.map(c => `
    <div class="flex items-center gap-2 mb-1 justify-between bg-white border border-neutral-200 rounded px-3 py-2">
      <span class="grow font-normal text-neutral-800 inline-flex items-center">
        <svg class="w-4 h-4 mr-1 text-neutral-500 inline-block align-middle" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-3.866-3.868-7-7.22-7-11A7 7 0 0112 3a7 7 0 017 7c0 3.78-3.134 7.132-7 11z" /><circle cx="12" cy="10" r="3" /></svg>
        ${c}</span>
      <button class="bg-neutral-900 hover:bg-neutral-700 text-white px-2 py-1 rounded transition font-medium flex items-center" onclick="loadFavorite('${c.replace(/'/g, "\\'")}')" title="<?= $t['see_weather'] ?>">
        <?= $t['see_weather'] ?>
      </button>
      <button class="bg-neutral-200 hover:bg-neutral-300 text-neutral-700 px-2 py-1 rounded transition font-medium" onclick="deleteFavorite('${c.replace(/'/g, "\\'")}')" title="<?= $t['delete'] ?>"> <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 7v13a2 2 0 002 2h8a2 2 0 002-2V7m-5 4v6m4-6v6m-8-6v6M4 7h16" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v1a2 2 0 002 2h2a2 2 0 002-2V3H9z"/></svg>
      </button>
    </div>
  `).join('');
}
renderFavorites();
function getLocation(evt) {
    evt.preventDefault();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coordsecto lo dejaré centrado con un pequeño margen si no indicas preferencia!.longitude;
            let params = new URLSearchParams(window.location.search);
            params.set('lat', lat);
            params.set('lon', lon);
            params.set('lang', urlLang);
            window.location.search = params.toString();
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
