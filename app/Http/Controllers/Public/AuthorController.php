<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller {
    public function index() {
        // Kuvame autorid koos raamatute arvuga
        $authors = Author::query()
            ->withCount('books')
            ->orderBy('last_name')
            ->paginate(12);

        return view('public.authors.index', compact('authors'));
    }

    public function show(Author $author) {
        // Kuvame autori ja tema raamatud
        $author->load(['books' => function ($q) {
            $q->orderBy('title');
        }]);

        return view('public.authors.show', compact('author'));
    }
}
