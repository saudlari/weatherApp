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
