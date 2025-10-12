<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Public\AuthorController;
use App\Http\Controllers\Public\BookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

# Laravelis lisab automaatselt kõik tüüpilised autentimise (login, logout, register, password reset, verify) 
# marsruudid ilma, et peaksid neid käsitsi routes/web.php faili kirjutama. Kontrollerid asuvad
# app/Http/Controllers/Auth/
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

# Avaliku vaate route-d
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');