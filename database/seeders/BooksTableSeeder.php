<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('books')->insert([
            ['title' => 'Snjeguljica', 'author' => 'Author 1', 'price' => 29.99, 'stock' => 10],
            ['title' => 'Crvenkapica', 'author' => 'Author 2', 'price' => 19.99, 'stock' => 15],
            // Dodaj više knjiga prema potrebi
        ]);
    }
}


