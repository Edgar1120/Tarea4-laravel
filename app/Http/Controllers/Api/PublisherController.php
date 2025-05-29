<?php

namespace App\Http\Controllers\Api;

use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::with('books')->get();
        return response()->json($publishers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'country' => 'required|string',
            'founded' => 'required|integer',
            'genere' => 'required|string',
        ]);

        $publisher = Publisher::create($validated);

        return response()->json([
            'message' => 'Editorial creada correctamente.',
            'publisher' => $publisher
        ], 201);
    }

    public function show(Publisher $publisher)
    {
        $publisher->load('books'); 
        return response()->json($publisher);
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'country' => 'required|string',
            'founded' => 'required|integer',
            'genere' => 'required|string',
        ]);

        $publisher->update($validated);

        return response()->json([
            'message' => 'Editorial actualizada correctamente.',
            'publisher' => $publisher
        ]);
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return response()->json([
            'message' => 'Editorial eliminada correctamente.'
        ]);
    }
}
