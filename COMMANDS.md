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

Vaata faili: resources/views/welcome.blade.php

# database logic
Vaata sisu peale loomist 
```
php artisan make:model Author -m
php artisan make:model Book -m
```

## Muuda migration faile

database/migrations/DATE_create_authors_table.php
```
$table->string('name'); # Autori nimi
$table->text('bio')->nullable(); # Autori biograafia
```

database/migrations/DATE_create_book_table.php
```
$table->foreignId('author_id')->constrained()->cascadeOnDelete(); # Seos teise mudeliga
$table->string('title'); # Raanmatu pealkiri
$table->year('published_year')->nullable(); # Avaldamise aasta
$table->string('isbn')->nullable()->unique(); # ISBN kood unikaalne
$table->unsignedInteger('pages')->nullable(); # Lehekülgede arv
```

## Loome admin kasutaja keskkonda (.env)
Kohanda arendajale sobivaks. Näidis variant lisa ka **.env.example** faili
```
ADMIN_NAME=Administraator
ADMIN_EMAIL=username@domain.com
ADMIN_PASSWORD="P4r00l"
```

## Andmefailid kust lugeda autorid ja raamatuid

Täienda, muuda vajadusel
fail: database/seeders/data/authors.csv
fail: database/seeders/data/books.csv

## Loome seeder failid (Autorite ja Raamatute jaoks)
```
php artisan make:seeder AuthorsTableSeeder
php artisan make:seeder BooksTableSeeder
```

Muuda faile

```
database\seeders\AuthorsTableSeeder.php
database\seeders\BooksTableSeeder.php

Järgnevat et mõlemad failid käivitatakse migreermisel ja lisaks et admin kasutaja ka lisatakse
database\seeders\DatabaseSeeder.php
```

## Andmebaasi täitmine andmetega (enne migreermine)
```
php artisan migrate # Migreerimine
php artisan db:seed # Tabelite täitmine andmetega
php artisan migrate:fresh --seed # Kui teha tabelid uuesti ja täita andmetega
```
