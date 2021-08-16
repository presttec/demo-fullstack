<?php

namespace App\Http\Controllers\Api;

use App\Models\Livro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    /**
     * Get a listing of the livro.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $livroQuery = Livro::query();
        $livroQuery->where('name', 'like', '%'.request('q').'%');
        $livros = $livroQuery->paginate(25);

        return $livros;
    }

    /**
     * Store a newly created livro in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Livro);

        $newLivro = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newLivro['creator_id'] = auth()->id();

        $livro = Livro::create($newLivro);

        return response()->json([
            'message' => __('livro.created'),
            'data'    => $livro,
        ], 201);
    }

    /**
     * Get the specified livro.
     *
     * @param  \App\Models\Livro  $livro
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Livro $livro)
    {
        return $livro;
    }

    /**
     * Update the specified livro in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Livro  $livro
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Livro $livro)
    {
        $this->authorize('update', $livro);

        $livroData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $livro->update($livroData);

        return response()->json([
            'message' => __('livro.updated'),
            'data'    => $livro,
        ]);
    }

    /**
     * Remove the specified livro from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Livro  $livro
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Livro $livro)
    {
        $this->authorize('delete', $livro);

        $request->validate(['livro_id' => 'required']);

        if ($request->get('livro_id') == $livro->id && $livro->delete()) {
            return response()->json(['message' => __('livro.deleted')]);
        }

        return response()->json('Unprocessable Entity.', 422);
    }
}
