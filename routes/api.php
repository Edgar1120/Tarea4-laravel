<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\PublisherController;


Route::get('/', function () {
    return response()->json(['message' => 'API de Libros funcionando correctamente.']);
});


Route::apiResource('authors', AuthorController::class);


Route::apiResource('publishers', PublisherController::class);


Route::apiResource('books', BookController::class);
