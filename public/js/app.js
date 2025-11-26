const FAV_KEY = 'weather_favorites';
let urlLang = document.documentElement.lang || 'en';
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
  if (urlLang) params.set('lang', urlLang);
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
  let t = root.dataset;
  if (!favs.length) {
    root.innerHTML = `<div class="opacity-60 italic text-center">${t.emptyFavs || 'No favorites yet'}</div>`;
    return;
  }
  root.innerHTML = `<div class="font-semibold text-neutral-800 mb-1">${t.favorites || 'Favorites'}:</div>` + favs.map(c => `
    <div class="flex items-center gap-2 mb-1 justify-between bg-white border border-neutral-200 rounded px-3 py-2">
      <span class="grow font-normal text-neutral-800 inline-flex items-center">
        <svg class="w-4 h-4 mr-1 text-neutral-500 inline-block align-middle" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-3.866-3.868-7-7.22-7-11A7 7 0 0112 3a7 7 0 017 7c0 3.78-3.134 7.132-7 11z" /><circle cx="12" cy="10" r="3" /></svg>
        ${c}</span>
      <button class="bg-neutral-900 hover:bg-neutral-700 text-white px-2 py-1 rounded transition font-medium flex items-center" onclick="loadFavorite('${c.replace(/'/g, "\\'")}')" title="${t.seeWeather || 'View'}">
        ${t.seeWeather || 'View'}
      </button>
      <button class="bg-neutral-200 hover:bg-neutral-300 text-neutral-700 px-2 py-1 rounded transition font-medium" onclick="deleteFavorite('${c.replace(/'/g, "\\'")}')" title="${t.delete || 'Delete'}"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 7v13a2 2 0 002 2h8a2 2 0 002-2V7m-5 4v6m4-6v6m-8-6v6M4 7h16" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v1a2 2 0 002 2h2a2 2 0 002-2V3H9z"/></svg></button>
    </div>
  `).join('');
}
document.addEventListener('DOMContentLoaded', renderFavorites);
function getLocation(evt) {
    evt.preventDefault();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            let params = new URLSearchParams(window.location.search);
            params.set('lat', lat);
            params.set('lon', lon);
            if (urlLang) params.set('lang', urlLang);
            window.location.search = params.toString();
        }, function(error) {
            alert('No pudimos obtener tu ubicación');
        });
    } else {
        alert('La Geolocalización no está soportada');
    }
}
