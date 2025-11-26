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
require_once __DIR__.'/../lang/messages.php';
$lang = $lang ?? ($_GET['lang'] ?? 'en');
$t = $translations[$lang] ?? $translations['en'];
$hasError = isset($weatherData['error']) && $weatherData['error'];
$isSuccess = !$hasError && isset($weatherData['cod']) && $weatherData['cod'] == 200;
?>
  <div class="w-full max-w-xl mx-auto p-6">
    <?php include __DIR__.'/partials/lang_selector.php'; ?>
    <div class="bg-white rounded-xl shadow-md px-6 py-8 border border-neutral-200">
      <div class="flex flex-col md:flex-row justify-between items-center mb-2 gap-2">
        <h1 class="text-3xl font-bold text-neutral-900 text-center flex items-center gap-2 justify-center">
          <svg class="inline w-8 h-8 text-yellow-400 align-top mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5" fill="#facc15" stroke="none"/><path d="M12 1v2M12 21v2M21 12h2M1 12H3M16.95 7.05l1.414-1.414M4.636 19.364l1.414-1.414M5.05 7.05 3.636 5.636M19.364 19.364l-1.414-1.414" stroke="#d97706" stroke-linecap="round"/></svg>
          <?= $t['app_title'] ?>
        </h1>
      </div>
      <?php include __DIR__.'/partials/search_form.php'; ?>
      <div class="text-sm text-neutral-600 mb-2 text-center"><?= $t['location_help'] ?></div>
      <?php include __DIR__.'/partials/favorites.php'; ?>
      <?php 
        if ($isSuccess):
          include __DIR__.'/partials/weather_card.php';
        elseif ($hasError):
          include __DIR__.'/partials/no_result.php';
        else: ?>
        <div class="bg-neutral-50 border border-neutral-200 text-neutral-600 text-center rounded-lg p-8 mt-4">
          <p class="text-lg font-medium">👆 <?= $t['input_hint'] ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
<script src="public/js/app.js"></script>
</body>
</html>
