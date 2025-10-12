<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller {
    public function __invoke() {
        // Cache 5 min — vajadusel muuda või eemalda
        $stats = Cache::remember('dashboard.stats', 300, function () { // 300 = 5 min
            $bookCount        = Book::count();
            $authorCount      = Author::count();
            $avgBooksPerAuthor= $authorCount ? round($bookCount / $authorCount, 2) : 0;

            $unchangedBooks   = Book::whereColumn('created_at', 'updated_at')->count();
            $changedBooks     = Book::whereColumn('created_at', '!=', 'updated_at')->count();
            $unchangedAuthors = Author::whereColumn('created_at', 'updated_at')->count();
            $changedAuthors   = Author::whereColumn('created_at', '!=', 'updated_at')->count();

            $booksWithoutIsbn = Book::whereNull('isbn')->orWhere('isbn', '')->count();
            $booksWithoutYear = Book::whereNull('published_year')->count();
            $newestYear       = Book::max('published_year');
            $oldestYear       = Book::min('published_year');
            $topAuthor        = Author::withCount('books')->orderByDesc('books_count')->first();

            return compact(
                'bookCount','authorCount','avgBooksPerAuthor',
                'unchangedBooks','changedBooks','unchangedAuthors','changedAuthors',
                'booksWithoutIsbn','booksWithoutYear','newestYear','oldestYear','topAuthor'
            );
        });

        return view('dashboard', $stats);
    }
}
