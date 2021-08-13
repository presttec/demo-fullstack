<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the author.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $authorQuery = Author::query();
        $authorQuery->where('name', 'like', '%'.request('q').'%');
        $authors = $authorQuery->paginate(25);

        return view('authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new author.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Author);

        return view('authors.create');
    }

    /**
     * Store a newly created author in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Author);

        $newAuthor = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newAuthor['creator_id'] = auth()->id();

        $author = Author::create($newAuthor);

        return redirect()->route('authors.show', $author);
    }

    /**
     * Display the specified author.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\View\View
     */
    public function show(Author $author)
    {
        return view('authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified author.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\View\View
     */
    public function edit(Author $author)
    {
        $this->authorize('update', $author);

        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified author in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Author $author)
    {
        $this->authorize('update', $author);

        $authorData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $author->update($authorData);

        return redirect()->route('authors.show', $author);
    }

    /**
     * Remove the specified author from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Author $author)
    {
        $this->authorize('delete', $author);

        $request->validate(['author_id' => 'required']);

        if ($request->get('author_id') == $author->id && $author->delete()) {
            return redirect()->route('authors.index');
        }

        return back();
    }
}
