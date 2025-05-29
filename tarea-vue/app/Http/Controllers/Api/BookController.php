<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'publisher'])->get();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'edition' => 'required|string',
            'copyright' => 'required|integer',
            'language' => 'required|string',
            'pages' => 'required|integer',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Libro creado correctamente.',
            'book' => $book
        ], 201);
    }

    public function show(Book $book)
    {
        $book->load(['author', 'publisher']);
        return response()->json($book);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'edition' => 'required|string',
            'copyright' => 'required|integer',
            'language' => 'required|string',
            'pages' => 'required|integer',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
        ]);

        $book->update($validated);

        return response()->json([
            'message' => 'Libro actualizado correctamente.',
            'book' => $book
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Libro eliminado correctamente.'
        ]);
    }
}
