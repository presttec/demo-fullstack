<?php

namespace App\Http\Controllers\Api;

use App\Models\Books;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Get a listing of the books.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $booksQuery = Books::query();
        $booksQuery->where('name', 'like', '%'.request('q').'%');
        $books = $booksQuery->paginate(25);

        return $books;
    }

    /**
     * Store a newly created books in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Books);

        $newBooks = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newBooks['creator_id'] = auth()->id();

        $books = Books::create($newBooks);

        return response()->json([
            'message' => __('books.created'),
            'data'    => $books,
        ], 201);
    }

    /**
     * Get the specified books.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Books $books)
    {
        return $books;
    }

    /**
     * Update the specified books in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Books $books)
    {
        $this->authorize('update', $books);

        $booksData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $books->update($booksData);

        return response()->json([
            'message' => __('books.updated'),
            'data'    => $books,
        ]);
    }

    /**
     * Remove the specified books from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Books $books)
    {
        $this->authorize('delete', $books);

        $request->validate(['books_id' => 'required']);

        if ($request->get('books_id') == $books->id && $books->delete()) {
            return response()->json(['message' => __('books.deleted')]);
        }

        return response()->json('Unprocessable Entity.', 422);
    }
}
