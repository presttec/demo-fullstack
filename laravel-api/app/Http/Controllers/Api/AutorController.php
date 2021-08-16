<?php

namespace App\Http\Controllers\Api;

use App\Models\Autor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    /**
     * Get a listing of the autor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $autorQuery = Autor::query();
        $autorQuery->where('name', 'like', '%'.request('q').'%');
        $autors = $autorQuery->paginate(25);

        return $autors;
    }

    /**
     * Store a newly created autor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Autor);

        $newAutor = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newAutor['creator_id'] = auth()->id();

        $autor = Autor::create($newAutor);

        return response()->json([
            'message' => __('autor.created'),
            'data'    => $autor,
        ], 201);
    }

    /**
     * Get the specified autor.
     *
     * @param  \App\Models\Autor  $autor
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Autor $autor)
    {
        return $autor;
    }

    /**
     * Update the specified autor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Autor  $autor
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Autor $autor)
    {
        $this->authorize('update', $autor);

        $autorData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $autor->update($autorData);

        return response()->json([
            'message' => __('autor.updated'),
            'data'    => $autor,
        ]);
    }

    /**
     * Remove the specified autor from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Autor  $autor
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Autor $autor)
    {
        $this->authorize('delete', $autor);

        $request->validate(['autor_id' => 'required']);

        if ($request->get('autor_id') == $autor->id && $autor->delete()) {
            return response()->json(['message' => __('autor.deleted')]);
        }

        return response()->json('Unprocessable Entity.', 422);
    }
}
