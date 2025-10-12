<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model {
    use HasFactory; // Võimaldab kirjutada -> Author::factory()->count(10)->create();

    // Vajalik lisamiseks ja muutmiseks (on lubatud mass-assignment’i jaoks)
    protected $fillable = [
        'name',
        'bio',
    ];
    
    // Seos mudeliga Book. Üks autor võib olla seotud miteme raamatuga. Autoril on palju raamatuid. Eloquenti seosed (relationships)
    public function books() {
        return $this->hasMany(Book::class);
    }
}
