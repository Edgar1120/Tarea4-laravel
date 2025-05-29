<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        Publisher::create([
            'name' => 'John Wiley & Sons',
            'country' => 'United States',
            'founded' => 1807,
            'genere' => 'Academic',
        ]);

        Publisher::create([
            'name' => 'Pearson Education',
            'country' => 'United Kingdom',
            'founded' => 1844,
            'genere' => 'Education',
        ]);
    }
}

