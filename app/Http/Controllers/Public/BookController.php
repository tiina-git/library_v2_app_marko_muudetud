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

    # Kasutaja, kes on sisse logitud aga puuduvad admin õigused
    public function userIndex(Request $request){
        $user = $request->user();
        // block admins — this view is for non-admin users only
        if (! $user || ($user->is_admin ?? false)) {
            abort(403);
        }

        $sort = $request->get('sort', 'title'); // 'title' or 'author'
        $direction = $request->get('direction', 'asc') === 'desc' ? 'desc' : 'asc';

        $query = Book::with('author');

        if ($sort === 'author') {
            // join authors so we can order by author name
            $query = $query->join('authors', 'books.author_id', '=', 'authors.id')
                ->select('books.*')
                ->orderBy('authors.name', $direction);
        } else {
            // default: order by book title
            $query = $query->orderBy('title', $direction);
        }

        $books = $query->paginate(20)->withQueryString();

        return view('user.bookslist', compact('books', 'sort', 'direction'));
    }
}
