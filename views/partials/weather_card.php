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
$ya_es_fav = in_array(mb_strtolower($cidade_nome), array_map('mb_strtolower',$fav_cities ?? []));
?>
<div class="flex justify-end mb-2">
<?php if (!$ya_es_fav): ?>
  <form method="POST" class="inline">
    <input type="hidden" name="add_fav" value="<?= $cidade_nome ?>">
    <input type="hidden" name="lang" value="<?= $lang ?>">
    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg font-semibold text-neutral-900 bg-neutral-200 hover:bg-neutral-300 border border-neutral-300 transition" title="<?= $t['add_favorite'] ?>">
      <svg class="w-5 h-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.97c.3.922-.755 1.688-1.538 1.118l-3.385-2.46a1 1 0 00-1.175 0l-3.385 2.46c-.783.57-1.838-.196-1.539-1.118l1.287-3.97A1 1 0 004.01 9.857l-3.385-2.46c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z"/>
      </svg>
      <?= $t['add_to_favs'] . $cidade_nome ?>
    </button>
  </form>
<?php else: ?>
  <span class="text-xs px-3 py-2 rounded bg-yellow-100 border border-yellow-300 text-yellow-700 flex items-center gap-1 select-none font-medium cursor-not-allowed">
    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.97c.3.922-.755 1.688-1.538 1.118l-3.385-2.46a1 1 0 00-1.175 0l-3.385 2.46c-.783.57-1.838-.196-1.539-1.118l1.287-3.97A1 1 0 004.01 9.857l-3.385-2.46c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z"/></svg>
    <?= $t['add_favorite'] ?>
  </span>
<?php endif; ?>
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
