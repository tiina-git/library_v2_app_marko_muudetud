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

# Kompileeri Frontend varad (CTRL+C kui tehtud)
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
Vaata/muuda sisu peale loomist 
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

# Avalik vaade (public_view)

Avaliku vaate routed routes\web.php
```
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
```

## Kontrollerid

Loome kontrollerid. Kontrolleid tulevad alam kausta Public (app\Http\Controllers\Public)
```
php artisan make:controller Public/AuthorController
php artisan make:controller Public/BookController
```

## Muudame olemasolevaid vaateid ja teeme vajadusel uued vaated
resources\views\layouts\app.blade.php
resources\views\layouts\nav.blade.php
resources\css\app.css # Lisatud .testing klass

resources\views\public\authors\index.blade.php
resources\views\public\authors\show.blade.php
resources\views\public\books\index.blade.php
resources\views\public\books\show.blade.php

## Muutame pagination osa Bootstrap jaoks.

  Fail: app\Providers\AppServiceProvider.php
  Lisa: Paginator::useBootstrapFive(); # Meetodis boot()
Import: use Illuminate\Pagination\Paginator;

# Administraatori osa

Logimine peaks töötama, kuid kuna asjad on nüüd poolikud ja uuendatud, siis enne edasi toimetamist on vaja routes korda teha ja lisada uued. Testida saab kui mõned asjad välja kommenteerida. Aga alustame siiski kontrolleritega.

## Loo admin lehe kontrollerid
```
# (eeldab, et mudelid Author ja Book on olemas)
php artisan make:controller Admin/AdminAuthorController --resource --model=Author
php artisan make:controller Admin/AdminBookController   --resource --model=Book
```

## Loo admin lehe vaated
```resources\views\admin\authors\_form.blade.php
resources\views\admin\authors\create.blade.php
resources\views\admin\authors\edit.blade.php
resources\views\admin\authors\index.blade.php

resources\views\admin\books\_form.blade.php
resources\views\admin\books\create.blade.php
resources\views\admin\books\edit.blade.php
resources\views\admin\books\index.blade.php
```

## home => dashboard

Muudetud home link ja vaade dashboardiks. Kontroller ka ja routes/web.php muudatus. Nagu eelmisel tunnil tehtud.
