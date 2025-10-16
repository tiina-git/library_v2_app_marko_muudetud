<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller {
    public function index(Request $request) {
        $q = trim((string)$request->get('q', ''));

        $query = Book::query()->with('author');
        // Otsing raamatuid raamatu nime, aasta, lk arvu, või autori nime järgi
        if ($q !== '' && mb_strlen($q) >= 3) { // miinimum sümbolite arv 3 tähemärki
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', '%' . $q . '%')
                    ->orWhere('published_year', 'like', '%' . $q . '%')
                    ->orWhere('pages', 'like', '%' . $q . '%')
                    ->orWhere('created_at', 'like', '%' . $q . '%')
                    ->orWhere('updated_at', 'like', '%' . $q . '%')
                    ->orWhereHas('author', function ($a) use ($q) {
                        $a->where('name', 'like', '%' . $q . '%');
                    });

                if (ctype_digit($q)) {      // kui tekst on number
                    $sub->orWhere('author_id', (int)$q)
                        ->orWhere('published_year', (int)$q)
                        ->orWhere('pages', (int)$q)
                        ->orWhereYear('created_at', (int)$q)
                        ->orWhereYear('updated_at', (int)$q);
                }
            });
        }

        $books = $query->orderBy('title')->paginate(8)->withQueryString(); // tulemuste arv lehel

        if ($request->boolean('partial') || $request->ajax()) {
            return view('public.books._results', compact('books', 'q'));
        }

        return view('public.books.index', compact('books', 'q'));
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
