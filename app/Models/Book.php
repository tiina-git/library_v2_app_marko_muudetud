<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model {
    use HasFactory; // Võimaldab kirjutada -> Book::factory()->count(10)->create();

    // Vajalik lisamiseks ja muutmiseks. (on lubatud mass-assignment’i jaoks)
    protected $fillable = [
        'author_id',
        'title',
        'published_year',
        'isbn',
        'pages',
    ];

    // Seos mudeliga Author. Üks raamat kuulub ühele autorile. Raamat kuulub autorile. Eloquenti seosed (relationships)
    public function author() {
        return $this->belongsTo(Author::class);
    }
}
