<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AdminAuthorController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $authors = Author::query()
            ->orderBy('name')            
            ->paginate(10);

        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('admin.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
         $data = $request->validate([            
            'name'      => ['required','string','min:2','max:100'],
            'bio'       => ['nullable','string','max:2000'],
        ]);

        Author::create($data);

        return redirect()->route('admin.authors.index')
            ->with('status', 'Autor lisatud.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)  {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author) {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)  {
        $data = $request->validate([
            'name' => ['required','string','min:2','max:100'],            
            'bio'        => ['nullable','string','max:2000'],
        ]);

        $author->update($data);

        return redirect()->route('admin.authors.index')
            ->with('status', 'Autor uuendatud.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author) {
        $author->delete();

        return redirect()->route('admin.authors.index')
            ->with('status', 'Autor kustutatud.');
    }
}
