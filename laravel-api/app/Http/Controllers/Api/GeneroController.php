<?php

namespace App\Http\Controllers\Api;

use App\Models\Genero;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    /**
     * Get a listing of the genero.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $generoQuery = Genero::query();
        $generoQuery->where('name', 'like', '%'.request('q').'%');
        $generos = $generoQuery->paginate(25);

        return $generos;
    }

    /**
     * Store a newly created genero in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Genero);

        $newGenero = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newGenero['creator_id'] = auth()->id();

        $genero = Genero::create($newGenero);

        return response()->json([
            'message' => __('genero.created'),
            'data'    => $genero,
        ], 201);
    }

    /**
     * Get the specified genero.
     *
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Genero $genero)
    {
        return $genero;
    }

    /**
     * Update the specified genero in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Genero $genero)
    {
        $this->authorize('update', $genero);

        $generoData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $genero->update($generoData);

        return response()->json([
            'message' => __('genero.updated'),
            'data'    => $genero,
        ]);
    }

    /**
     * Remove the specified genero from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Genero $genero)
    {
        $this->authorize('delete', $genero);

        $request->validate(['genero_id' => 'required']);

        if ($request->get('genero_id') == $genero->id && $genero->delete()) {
            return response()->json(['message' => __('genero.deleted')]);
        }

        return response()->json('Unprocessable Entity.', 422);
    }
}
