<form method="GET" class="flex gap-2 mb-4">
  <input type="hidden" name="lang" value="<?= $lang ?>">
  <input type="text" name="cidade" id="cidade"
    placeholder="<?= $t['search_placeholder'] ?>"
    value="<?= htmlspecialchars($city) ?>" required
    class="flex-1 px-4 py-2 rounded-lg border border-neutral-300 focus:ring-2 focus:ring-neutral-400 focus:outline-none bg-neutral-50 text-neutral-900 placeholder:text-neutral-400">
  <button type="submit" class="px-5 py-2 text-white font-medium rounded-lg bg-neutral-900 hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-neutral-400 transition">
    <?= $t['search_button'] ?>
  </button>
  <button type="button" onclick="getLocation(event)" title="<?= $t['location_button'] ?>"
    class="px-4 py-2 bg-neutral-200 hover:bg-neutral-300 text-neutral-700 font-bold rounded-lg focus:ring-2 focus:ring-neutral-400 transition border border-neutral-300 flex items-center justify-center">
    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-3.866-3.868-7-7.22-7-11A7 7 0 0112 3a7 7 0 017 7c0 3.78-3.134 7.132-7 11z" /><circle cx="12" cy="10" r="3" /></svg>
  </button>
</form>
