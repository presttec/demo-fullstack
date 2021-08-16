<?php

namespace App\Http\Controllers\Api;

use App\Models\Editora;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditoraController extends Controller
{
    /**
     * Get a listing of the editora.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $editoraQuery = Editora::query();
        $editoraQuery->where('name', 'like', '%'.request('q').'%');
        $editoras = $editoraQuery->paginate(25);

        return $editoras;
    }

    /**
     * Store a newly created editora in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Editora);

        $newEditora = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newEditora['creator_id'] = auth()->id();

        $editora = Editora::create($newEditora);

        return response()->json([
            'message' => __('editora.created'),
            'data'    => $editora,
        ], 201);
    }

    /**
     * Get the specified editora.
     *
     * @param  \App\Models\Editora  $editora
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Editora $editora)
    {
        return $editora;
    }

    /**
     * Update the specified editora in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Editora  $editora
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Editora $editora)
    {
        $this->authorize('update', $editora);

        $editoraData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $editora->update($editoraData);

        return response()->json([
            'message' => __('editora.updated'),
            'data'    => $editora,
        ]);
    }

    /**
     * Remove the specified editora from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Editora  $editora
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Editora $editora)
    {
        $this->authorize('delete', $editora);

        $request->validate(['editora_id' => 'required']);

        if ($request->get('editora_id') == $editora->id && $editora->delete()) {
            return response()->json(['message' => __('editora.deleted')]);
        }

        return response()->json('Unprocessable Entity.', 422);
    }
}
