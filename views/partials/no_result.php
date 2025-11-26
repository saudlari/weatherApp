<div class="bg-neutral-200 border border-neutral-400 text-neutral-700 px-4 py-3 rounded-lg text-center mt-6">
  <p class="font-semibold">❌ <?= htmlspecialchars($weatherData['message'] ?? $t['city_error']); ?></p>
  <?php if (empty(WEATHER_API_KEY) || WEATHER_API_KEY === 'SUA_CHAVE_API_AQUI'): ?>
    <p class="mt-2 text-xs font-mono px-4 py-1.5 bg-neutral-300 rounded">⚠️ <?= $t['api_key_help'] ?></p>
  <?php endif; ?>
</div>
