<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller {
    public function index(Request $request) {
        $q = trim((string) $request->get('q', ''));
        $isNumeric = $q !== '' && ctype_digit($q);

        $query = Book::query()->with('author');

        // Otsing: kõik olulised väljad raamatust ja autorist, v.a. raamatu 'isbn'
        if ($q !== '' && mb_strlen($q) >= 3) { // miinimum 3 märki
            $query->where(function ($sub) use ($q, $isNumeric) {
                // Raamat (isbn on teadlikult välja jäetud)
                $sub->where('title', 'like', '%' . $q . '%')
                    ->orWhere('published_year', 'like', '%' . $q . '%')
                    ->orWhere('pages', 'like', '%' . $q . '%')
                    ->orWhere('created_at', 'like', '%' . $q . '%')
                    ->orWhere('updated_at', 'like', '%' . $q . '%')

                    // Autor: nimi, bio, ajatempli väljad
                    ->orWhereHas('author', function ($a) use ($q, $isNumeric) {
                        $a->where(function ($aa) use ($q) {
                            $aa->where('name', 'like', '%' . $q . '%')
                               ->orWhere('bio', 'like', '%' . $q . '%')
                               ->orWhere('created_at', 'like', '%' . $q . '%')
                               ->orWhere('updated_at', 'like', '%' . $q . '%');
                        });

                        // Numbrilise päringu puhul aastapõhised vasted ka autori ajatemplitelt
                        if ($isNumeric) {
                            $a->orWhereYear('created_at', (int) $q)
                              ->orWhereYear('updated_at', (int) $q);
                        }
                    });

                // Numbrilise päringu korral täpsed/“YEAR()” vasted raamatu väljadelt
                if ($isNumeric) {
                    $sub->orWhere('author_id', (int) $q)
                        ->orWhere('published_year', (int) $q)
                        ->orWhere('pages', (int) $q)
                        ->orWhereYear('created_at', (int) $q)
                        ->orWhereYear('updated_at', (int) $q);
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
        // Allow any authenticated user (admin or non-admin) to view the list
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
