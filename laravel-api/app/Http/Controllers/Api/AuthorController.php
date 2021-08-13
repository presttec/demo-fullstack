<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Get a listing of the author.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $authorQuery = Author::query();
        $authorQuery->where('name', 'like', '%'.request('q').'%');
        $authors = $authorQuery->paginate(25);

        return $authors;
    }

    /**
     * Store a newly created author in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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

        return response()->json([
            'message' => __('author.created'),
            'data'    => $author,
        ], 201);
    }

    /**
     * Get the specified author.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Author $author)
    {
        return $author;
    }

    /**
     * Update the specified author in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Author $author)
    {
        $this->authorize('update', $author);

        $authorData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $author->update($authorData);

        return response()->json([
            'message' => __('author.updated'),
            'data'    => $author,
        ]);
    }

    /**
     * Remove the specified author from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Author $author)
    {
        $this->authorize('delete', $author);

        $request->validate(['author_id' => 'required']);

        if ($request->get('author_id') == $author->id && $author->delete()) {
            return response()->json(['message' => __('author.deleted')]);
        }

        return response()->json('Unprocessable Entity.', 422);
    }
}
