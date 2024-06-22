<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Book::query()->exists()) {
            for ($i = 0; $i < 10; $i++) {
                Book::factory()->has(Author::factory()->count(rand(1, 3)))->create();
            }
        }
    }
}
