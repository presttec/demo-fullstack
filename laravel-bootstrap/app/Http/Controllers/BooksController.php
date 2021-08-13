<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $booksQuery = Books::query();
        $booksQuery->where('name', 'like', '%'.request('q').'%');
        $books = $booksQuery->paginate(25);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new books.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Books);

        return view('books.create');
    }

    /**
     * Store a newly created books in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
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

        return redirect()->route('books.show', $books);
    }

    /**
     * Display the specified books.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\View\View
     */
    public function show(Books $books)
    {
        return view('books.show', compact('books'));
    }

    /**
     * Show the form for editing the specified books.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\View\View
     */
    public function edit(Books $books)
    {
        $this->authorize('update', $books);

        return view('books.edit', compact('books'));
    }

    /**
     * Update the specified books in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Books $books)
    {
        $this->authorize('update', $books);

        $booksData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $books->update($booksData);

        return redirect()->route('books.show', $books);
    }

    /**
     * Remove the specified books from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Books $books)
    {
        $this->authorize('delete', $books);

        $request->validate(['books_id' => 'required']);

        if ($request->get('books_id') == $books->id && $books->delete()) {
            return redirect()->route('books.index');
        }

        return back();
    }
}
