# Libaray v2 App

Tegevused mis on tehtud, on [COMMANDS.md](COMMANDS.md) failis.

# Paigaldamine

1. Käivita Visual Code
2. Kui eelnev projekt on avatud, siis sulge (File->Close Folder) või ava uus Visual Code aken (New->New Window)
3. Kliki Source Control (Ctrl + Shift + G)
4. Kliki nuppu Clone Repository ja kleebi reale aadress: https://github.com/OkramL/library_v2_app_marko.git ja vajuta Enter. Siis otsi kaust kuhu soovid projekti panna (laravel_projects, ta tekitab ka ise kausta (library_v2_app_marko))

# Seadistamine

1. Käivita Windows Terminal (Powershell) või Command Prompt (cmd) projekti kaustas
2. Paigalda sõltuvused: 
```
    composer install
```
3. .env ja rakenduse võti 
```
    copy .env.example .env 
    php artisan key:generate
```

4. Seadista andmebaasi osa .env failis
```
    DB_DATABASE=C:\Users\USERNAME\Documents\laravel-projects\library_v2_app_marko\database\database.sqlite
    DB_FOREIGN_KEYS=true
```
5. Seadista admin kasutaja .env failis, sobivate andmetega
```
    ADMIN_NAME="Administraator"
    ADMIN_EMAIL=username@domain.com
    ADMIN_PASSWORD="YourPasswOrd"
```

6. Migratsioonid ja seederid
```
    php artisan migrate --seed # Vasta yes, et luua andmebaasnpm install 
    php artisan migrate:fresh --seed # Kui soovid puhtalt alustada (admin kasutajat siis pole!)
```

7. Frontendi assetid
```
    npm install
    npm run dev   # arenduseks; produktsiooniks: npm run build

```

8. Vahemälu puhastuseks
```
    php artisan optimize:clear
```

9. Käivita rakendus
```
    php artisan serve
```

Muudatused

#  16.oktoober
1. Sisselogimine parooliga, kajastamine andmebaasis.

LoginController.php
	protected function authenticated(Request $request, $user){...}

2. Kasutajate kontode vaatamine ja kustutamine Administraatorina
UserController.php
	public function index(){...}
	public function destroy(User $user){...}
	
Uus fail "Kasutajad" 
	resources/views/admin/users/index.blade.php

Web.php	- Routes update
	[UserController::class, 'index']
	[UserController::class, 'destroy'])
	
nav.blade.php - Rippmenüüsse link juurde "Kasutajad"
	 <a class="dropdown-item" href="{{ route('admin.users.index') }}">
	
3. Raamatute tabeli vaade sisselogitud kasutajale
Uus fail "Raamatute nimekiri"
	resources/views/user/bookslist.blade.php

nav.blade.php - Rippmenüüsse link juurde "Raamatute nimekiri"
	<a class="dropdown-item" href="{{ route('bookslist') }}">
	
BookController.phph
	 public function userIndex(Request $request){...}
	 
Web.php	- Routes update, bookslist.blade
	[BookController::class, 'userIndex']
	
4. Raamatute otsimine, min 3 märki
	search.blade.php	
	public function index(Request $request) {...}
	
5. Raamatute import CSV failist, Admin
Uus fail "Raamatute import"
	resources/views/admin/books/import.blade.php
	
nav.blade.php - Rippmenüüsse link juurde "Raamatute import"
	<a class="dropdown-item" href="{{ route('admin.books.import') }}">
	
AdminBooksController.php
	public function importForm(){...}
	public function import(Request $request){...}
	
Web.php	- Routes update
[AdminBookController::class, 'importForm']
[AdminBookController::class, 'import']

6. Süsteemikonto Admin, 
Muutisn andmeid '.env' failis , panin 'tiina.uuk@kehtna.edu.ee' e-maili 
Tegin andmebaasi uuesti ja liasin kõik andmed hiljem tagasi.
Lisaks (Marko, marko.livental@rako.edu.ee, Parool: 1...8)
Lisasin administraatori check box-i.
	

