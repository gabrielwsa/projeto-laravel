<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        return response()->json([
            'authors' => Author::all()
        ]);
    }

    public function show($id)
    {
        if(!Author::find($id)){
            return response()->json([
                'message' => 'Author not found'
            ], 404);
        }

        return response()->json([
            'author' => Author::find($id),
            'books' => Author::find($id)->books
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'birthdate' => 'required',
            'nationality' => 'required'
        ]);

        $author = Author::create([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'nationality' => $request->nationality
        ]);

        return response()->json([
            'message' => 'Author created successfully',
            'author' => $author
        ]);
    }

    public function update(Request $request, $id)
    {
        $author = Author::find($id);

        if(!$author){
            return response()->json([
                'message' => 'Author not found'
            ], 404);
        }

        try {
            $author->update([
                'name' => $request->name ?? $author->name,
                'birthdate' => $request->birthdate ?? $author->birthdate,
                'nationality' => $request->nationality ?? $author->nationality
            ]);

            return response()->json([
                'message' => 'Author updated successfully',
                'author' => $author
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating author',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $author = Author::find($id);

        if(!$author){
            return response()->json([
                'message' => 'Author not found'
            ], 404);
        }

        $author->delete();

        return response()->json([
            'message' => 'Author deleted successfully'
        ]);
    }
}
