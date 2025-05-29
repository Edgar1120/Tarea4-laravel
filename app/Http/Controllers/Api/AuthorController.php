<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::with('books')->get();
        return response()->json($authors);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'nationality' => 'required|string',
            'birth_year' => 'required|integer',
            'fields' => 'required|string',
        ]);

        $author = Author::create($validated);

        return response()->json([
            'message' => 'Autor creado correctamente.',
            'author' => $author
        ], 201);
    }

    public function show(Author $author)
    {
        $author->load('books');
        return response()->json($author);
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'nationality' => 'required|string',
            'birth_year' => 'required|integer',
            'fields' => 'required|string',
        ]);

        $author->update($validated);

        return response()->json([
            'message' => 'Autor actualizado correctamente.',
            'author' => $author
        ]);
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'message' => 'Autor eliminado correctamente.'
        ]);
    }
}
