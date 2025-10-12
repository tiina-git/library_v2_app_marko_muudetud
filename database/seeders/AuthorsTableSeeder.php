<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SplFileObject;

class AuthorsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $path = database_path('seeders/data/authors.csv'); # Faili asukoht
        if (!is_file($path)) return;

        $file = new SplFileObject($path);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
        $file->setCsvControl(';');

        $isHeader = true;
        foreach ($file as $row) {
            if ($row === [null] || $row === false) continue;
            if ($isHeader) { $isHeader = false; continue; }

            [$id, $name, $bio, $created_at, $updated_at] = array_pad($row, 5, null);
            if (!$name) continue;

            # Loo andmebaasi kirje uuendamise või lisamisega
            DB::table('authors')->updateOrInsert(
                ['id' => (int)$id],
                [
                    'name'       => $name,
                    'bio'        => $bio,
                    'created_at' => $created_at ?: now(),
                    'updated_at' => $updated_at ?: now(),
                ]
            );
        }
    }
}
