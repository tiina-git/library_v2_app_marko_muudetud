<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller {
    public function index() {
        // Kuvame raamatud koos autori infoga
        $books = Book::query()
            ->with('author')
            ->orderBy('title')
            ->paginate(8);

        return view('public.books.index', compact('books'));
    }

    public function show(Book $book) {
        $book->load('author'); // see on Eloquenti lazy eager loading. (Vajalik autori nime jaoks)
        return view('public.books.show', compact('book'));
    }
}