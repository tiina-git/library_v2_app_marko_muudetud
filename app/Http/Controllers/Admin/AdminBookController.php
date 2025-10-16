<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use SplFileObject;

class AdminBookController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $books = Book::query()
            ->with('author')
            ->orderBy('title')
            ->paginate(10);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $authors = Author::orderBy('name')->get(['id','name']);
        return view('admin.books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'author_id'      => ['required','exists:authors,id'],
            'title'          => ['required','string','min:2','max:255'],
            'published_year' => ['nullable','integer','digits:4','between:1000,2100'],
            'isbn'           => ['nullable','string','max:20', Rule::unique('books','isbn')],
            'pages'          => ['nullable','integer','min:1'],
        ]);

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('status', 'Raamat lisatud.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book) {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book) {
        $authors = Author::orderBy('name')->get(['id','name']);
        return view('admin.books.edit', compact('book','authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book) {
        $data = $request->validate([
            'author_id'      => ['required','exists:authors,id'],
            'title'          => ['required','string','min:2','max:255'],
            'published_year' => ['nullable','integer','digits:4','between:1000,2100'],
            // Ehk: ISBN peab olema unikaalne kõigi teiste raamatute seas, aga sama rida, mida sa parasjagu uuendad, ei loe “duplikaadiks”.
            'isbn'           => ['nullable','string','max:20', Rule::unique('books','isbn')->ignore($book->id)],
            'pages'          => ['nullable','integer','min:1'],
        ]);

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('status', 'Raamat uuendatud.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)  {
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('status', 'Raamat kustutatud.');
    }

    
    /**
     * Show CSV import form (admin only via routes).
     */
    public function importForm()
    {
        return view('admin.books.import');
    }

    /**
     * Process uploaded CSV and create/update authors and books.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ]);

        $file = $request->file('csv');
        $path = $file->getRealPath();

        $fp = new SplFileObject($path);
        $fp->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
        $fp->setCsvControl(';');

        $created = 0;
        $updated = 0;
        $skipped = 0;

        DB::transaction(function () use ($fp, &$created, &$updated, &$skipped) {
            // cache existing authors by exact name to avoid repeated queries
            $authors = Author::pluck('id', 'name')->toArray(); // name => id

            $isHeader = true;
            foreach ($fp as $row) {
                if ($row === [null] || $row === false) {
                    continue;
                }

                if ($isHeader) { $isHeader = false; continue; } // skip header

                // Expecting CSV: Autor;Raamatunimi;Aasta;Isbn;Lehekülgi
                [$authorName, $title, $year, $isbn, $pages] = array_pad($row, 5, '');

                $authorName = trim((string)$authorName);
                $title = trim((string)$title);
                $year = trim((string)$year);
                $isbn = trim((string)$isbn);
                $pages = trim((string)$pages);

                if ($title === '') {
                    $skipped++;
                    continue;
                }

                // ensure author exists
                if ($authorName === '') {
                    // optional: skip or set null author; here skip
                    $skipped++;
                    continue;
                }

                if (!isset($authors[$authorName])) {
                    $newAuthor = Author::create(['name' => $authorName]);
                    $authorId = $newAuthor->id;
                    $authors[$authorName] = $authorId;
                } else {
                    $authorId = $authors[$authorName];
                }

                $bookData = [
                    'author_id'      => $authorId,
                    'title'          => $title,
                    'published_year' => $year !== '' ? (int)$year : null,
                    'isbn'           => $isbn !== '' ? $isbn : null,
                    'pages'          => $pages !== '' ? (int)$pages : null,
                ];

                // prefer unique by ISBN when present
                if (!empty($bookData['isbn'])) {
                    $book = Book::updateOrCreate(
                        ['isbn' => $bookData['isbn']],
                        $bookData
                    );
                } else {
                    // otherwise match by title + author
                    $book = Book::updateOrCreate(
                        ['title' => $bookData['title'], 'author_id' => $bookData['author_id']],
                        $bookData
                    );
                }

                if ($book->wasRecentlyCreated) {
                    $created++;
                } else {
                    $updated++;
                }
            }
        });

        return redirect()->route('admin.books.index')
            ->with('status', "Import lõpetatud. Loodud: {$created}, uuendatud: {$updated}, vahele jäetud: {$skipped}.");
    }
}
