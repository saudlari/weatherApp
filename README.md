# Weather App PHP ☁️

A modern, maintainable weather web app built with pure PHP using MVC structure, TailwindCSS, and favorites CRUD managed with PHP sessions (no JS persistence). You can check the current weather, manage favorite cities, use geolocation, and switch languages (EN, ES, PT).

## 🚀 Features

- Get current weather by city name or your current geolocation (OpenWeatherMap API)
- Fully manage your favorite cities (create, read, delete, clear all) using PHP session — **no LocalStorage/JS for CRUD**
- Multilingual: English, Spanish, Portuguese (language selector, top left)
- Beautiful, responsive UI thanks to TailwindCSS
- User-friendly error messages and helpful prompts

## 🛠 Installation

1. **Clone this repository:**
   ```bash
   git clone ... && cd weather-app
   ```

2. **Make sure you have:**
   - PHP 7.4+ (with ext-curl and ext-mbstring)
   - Tailwind via CDN (already included in the main view)

   Example install on Ubuntu:
   ```bash
   sudo apt install php php-curl php-mbstring
   ```

3. **Configure your OpenWeatherMap API Key:**
   1. Sign up for a free API key at https://openweathermap.org/api
   2. Copy `config/config.local.php.example` to `config/config.local.php`
   3. Paste your key as shown:
      ```php
      <?php
      define('WEATHER_API_KEY', 'YOUR_API_KEY');
      ```

## ▶️ Running the App Locally

```bash
php -S localhost:8000
# Visit http://localhost:8000 in your browser
```

## 🌐 What can you do?

- Search for the weather anywhere in the world
- Get your current location's weather with a single click ("📍")
- Manage your favorite cities — add, view, delete, clear all (entirely with PHP sessions)
- Switch language instantly; the whole UI adapts
- All UI is built with clean, scalable Tailwind utility classes

## 📂 Folder structure

- `/controllers/WeatherController.php` — orchestrates logic and favorites (in session)
- `/src/Weather/WeatherService.php` — handles all API requests
- `/views/partials/` — modular components: search, favorites, weather card, etc.
- `/lang/messages.php` — all translated UI messages and labels

## 🤝 Credits

- Original app by Larissa Saud [@saudlari]
- Weather icons from OpenWeatherMap and inlined SVGs (Heroicons open source)

## ⚠️ Notes

- **No database or JS-based favorite persistence:** all favorites are managed via PHP sessions!
- If you see only errors, check your API key and internet connection.
- Fully maintainable: feel free to swap partials, add features, or internationalize further.

---

Have fun exploring and improving!  
Want to add new features? Check the clean structure — this app is ready to grow.
