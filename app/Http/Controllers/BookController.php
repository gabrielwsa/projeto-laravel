<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    public function index()
    {
        return response()->json([
            'books' => Book::all()
        ]);
    }

    public function show($id)
    {
        if(!Book::find($id)){
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        return response()->json([
            'book' => Book::find($id),
            'author' => Book::find($id)->author
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'publication_date' => 'required',
            'isbn' => 'required',
            'author_id' => 'required'
        ]);

        try {

            $author = Author::find($request->author_id);

            if(!$author){
                return response()->json([
                    'message' => 'Author not found'
                ], 404);
            }


            $book = Book::create([
                'title' => $request->title,
                'publication_date' => $request->publication_date,
                'isbn' => $request->isbn,
                'author_id' => $request->author_id
            ]);

            return response()->json([
                'message' => 'Book created successfully',
                'book' => $book
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if(!$book){
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        try {

            $author = Author::find($request->author_id);

            if(isset($request->author_id)){
                if(!$author){
                    return response()->json([
                        'message' => 'Author not found'
                    ], 404);
                }
            }

            $book->update([
                'title' => $request->title ?? $book->title,
                'isbn' => $request->isbn ?? $book->isbn,
                'publication_date' => $request->publication_date ?? $book->publication_date,
                'author_id' => $request->author_id ?? $book->author_id
            ]);

            return response()->json([
                'message' => 'Book updated successfully',
                'book' => $book
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if(!$book){
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }
    
}
