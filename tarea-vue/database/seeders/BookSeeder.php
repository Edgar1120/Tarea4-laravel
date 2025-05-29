<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'title' => 'Operating System Concepts',
            'edition' => '9th',
            'copyright' => 2012,
            'language' => 'ENGLISH',
            'pages' => 976,
            'author_id' => 1,
            'publisher_id' => 1,
        ]);

        Book::create([
            'title' => 'Database System Concepts',
            'edition' => '6th',
            'copyright' => 2010,
            'language' => 'ENGLISH',
            'pages' => 1376,
            'author_id' => 1,
            'publisher_id' => 1,
        ]);

        Book::create([
            'title' => 'Computer Networks',
            'edition' => '5th',
            'copyright' => 2010,
            'language' => 'ENGLISH',
            'pages' => 960,
            'author_id' => 2,
            'publisher_id' => 2,
        ]);

        Book::create([
            'title' => 'Modern Operating Systems',
            'edition' => '4th',
            'copyright' => 2014,
            'language' => 'ENGLISH',
            'pages' => 1136,
            'author_id' => 2,
            'publisher_id' => 2,
        ]);
    }
}
