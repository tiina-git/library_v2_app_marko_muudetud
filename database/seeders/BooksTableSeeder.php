<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SplFileObject;

class BooksTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $path = database_path('seeders/data/books.csv');
        if (!is_file($path)) return;

        $file = new SplFileObject($path);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
        $file->setCsvControl(';');

        $isHeader = true;
        foreach ($file as $row) {
            if ($row === [null] || $row === false) continue;
            if ($isHeader) { $isHeader = false; continue; }

            [$id, $author_id, $title, $published_year, $isbn, $pages, $created_at, $updated_at]
                = array_pad($row, 8, null);
            if (!$title) continue;

            # Loob andmebasai kirje uuendamise või lisamisega
            DB::table('books')->updateOrInsert(
                ['id' => (int)$id],
                [
                    'author_id'      => (int)$author_id,
                    'title'          => $title,
                    'published_year' => $published_year ? (int)$published_year : null,
                    'isbn'           => $isbn ?: null,
                    'pages'          => $pages ? (int)$pages : null,
                    'created_at'     => $created_at ?: now(),
                    'updated_at'     => $updated_at ?: now(),
                ]
            );
        }
    }
}
