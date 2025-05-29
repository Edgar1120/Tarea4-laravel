<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::create([
            'name' => 'Abraham Silberschatz',
            'nationality' => 'Israelis / American',
            'birth_year' => 1952,
            'fields' => 'Database Systems, Operating Systems',
        ]);

        Author::create([
            'name' => 'Andrew S. Tanenbaum',
            'nationality' => 'Dutch / American',
            'birth_year' => 1944,
            'fields' => 'Distributed computing, Operating Systems',
        ]);
    }
}

