<?php

use App\Http\Controllers\Admin\AdminAuthorController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Public\AuthorController;
use App\Http\Controllers\Public\BookController;
use App\Http\Controllers\Public\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

# Laravelis lisab automaatselt kõik tüüpilised autentimise (login, logout, register, password reset, verify) 
# marsruudid ilma, et peaksid neid käsitsi routes/web.php faili kirjutama. Kontrollerid asuvad
# app/Http/Controllers/Auth/
Auth::routes(['register' => false]); // Keela registreerimise võimalus avalikul kasutajal

// tänu __invoke() meetodile pole vaja meetodit lisada (index, show, create ...)
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'force.password.change']) // Lisa parooli muutmise middleware
    ->name('dashboard');

# Avaliku vaate route-d
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])
    ->name('oauth.google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('oauth.google.callback');

Route::get('/search', [SearchController::class, 'index'])->name('search'); # Lisasin

# Sisse logitud kasutajad, kes pole admin õigustega
Route::get('/user/bookslist', [BookController::class, 'userIndex']) # Lisasin
    ->middleware('auth') // only logged-in users
    ->name('bookslist');

# Administraatori vaate osad
Route::middleware(['auth', 'force.password.change'])->prefix('admin')->name('admin.')->group(function () {
    // Adminile mõeldud osa
    Route::middleware('can:manage-users')->group(function () {
    // Autorid ja raamatud (lisa, muuda, eemalda)
        Route::resource('authors', AdminAuthorController::class)->except(['show']);
        Route::resource('books',   AdminBookController::class)->except(['show']);
 
    // Loo ja salvesta uus kasutaja
    Route::get('users', [UserController::class, 'index'])->name('users.index'); # Lisasin
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); # Lisasin

    // CSV failist raamatute import 
    Route::get('books/import', [AdminBookController::class, 'importForm'])->name('books.import.form');# Lisasin
    Route::post('books/import', [AdminBookController::class, 'import'])->name('books.import'); # Lisasin
    });
        
    // Parooli muutmise vorm ja uuendamine
    Route::get('/password/change', [ChangePasswordController::class, 'edit'])->name('password.change'); 
    Route::put('/password/change', [ChangePasswordController::class, 'update'])->name('password.update');
    
});
// parooli muutmise lõpp