# Loome projekti
composer create-project laravel/laravel library_v2_app_marko

# Paigaldame lokaalse Bootstrap 5.3
npm install bootstrap@5.3.0

# Paigalda Laravel UI Pakett
composer require laravel/ui

# Genereeri Bootstrap Auth (Controller kirjutatakse üle (tühi))
+ Loob resources/views/auth/ kausta koos vaadetega
+ Loob resources/views/layouts/app.blade.php layouti
+ Loob app/Http/Controllers/Auth/ kausta koos controlleritega
+ Loob app/Http/Controllers/HomeController.php
+ Lisab auth route'd routes/web.php faili

php artisan ui bootstrap --auth

# Paigalda NPM sõltuvused
npm install

# Kompileeri Frontend aarad (CTRL+C kui tehtud)
npm run dev

# Andmebaasi muudatused (.env)
DB_CONNECTION=sqlite
DB_DATABASE=C:\Users\USERNAME\Documents\laravel_projects\library_new\database\database.sqlite
DB_FOREIGN_KEYS=true # Vajalik SQLite puhul

# app.js ja app.css (tühi või enda stiilid)
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '../css/app.css';

# app.css peab tühi olema
resources/css/app.css

# vite.config.js sisu
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});

# welcome.blade.php on vaja uuesti teha (ilma tailwindita)