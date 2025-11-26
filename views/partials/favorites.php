<div class="mt-2">
  <?php if (empty($fav_cities)): ?>
    <div class="opacity-60 italic text-center"><?= $t['empty_favs'] ?></div>
  <?php else: ?>
    <div class="flex flex-col gap-2 mb-2">
      <div class="font-semibold text-neutral-800 mb-1"><?= $t['favorites'] ?>:</div>
      <?php foreach ($fav_cities as $c): ?>
        <div class="flex items-center gap-2 bg-white border border-neutral-200 rounded px-3 py-2 justify-between">
          <form method="GET" class="inline">
            <input type="hidden" name="lang" value="<?= htmlspecialchars($lang) ?>">
            <input type="hidden" name="cidade" value="<?= htmlspecialchars($c) ?>">
            <button type="submit" class="bg-neutral-900 hover:bg-neutral-700 text-white px-2 py-1 rounded font-medium flex items-center" title="<?= $t['see_weather'] ?>">
              <svg class="w-4 h-4 mr-1 text-neutral-500" ...></svg><?= $c ?>
            </button>
          </form>
          <form method="POST" class="inline">
            <input type="hidden" name="del_fav" value="<?= htmlspecialchars($c) ?>">
            <button type="submit" class="bg-neutral-200 hover:bg-neutral-300 text-neutral-700 px-2 py-1 rounded font-medium" title="<?= $t['delete'] ?>">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 7v13a2 2 0 002 2h8a2 2 0 002-2V7m-5 4v6m4-6v6m-8-6v6M4 7h16" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v1a2 2 0 002 2h2a2 2 0 002-2V3H9z"/></svg>
            </button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
    <form method="POST" class="flex justify-end">
      <input type="hidden" name="clear_favs" value="1">
      <button type="submit" class="text-xs border rounded bg-neutral-100 text-neutral-500 hover:bg-red-100 hover:text-red-800 px-3 py-2 transition">
        <?= $t['clear_all'] ?>
      </button>
    </form>
  <?php endif; ?>
</div>
