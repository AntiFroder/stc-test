<?php

declare(strict_types=1);


use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::post('books/datatable', [BookController::class, 'getData']);
Route::get('books/filters-data', [BookController::class, 'getDataFilters']);
