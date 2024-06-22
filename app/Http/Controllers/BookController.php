<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataTableRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function getData(DataTableRequest $request): JsonResponse
    {
        $bookQuery = Book::with('authors');
        $this->applyFilters($bookQuery, $request->validated());
        $data = $bookQuery->get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'authors' => implode(', ', $book->authors->pluck('full_name')->toArray()),
                'author_count' => $book->authors->count()
            ];
        });
        return response()->json($data);
    }

    private function applyFilters(Builder &$books, array $filters): void
    {
        if ($filters['author'] !== null) {
            $books->whereHas('authors', function ($query) use($filters) {
                $query->where('id', $filters['author']);
            });
        }
    }

    public function getDataFilters(): JsonResponse
    {
        return response()->json(Author::get(['authors.id', 'authors.full_name']));
    }
}
