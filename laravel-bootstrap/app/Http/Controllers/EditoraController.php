<?php

namespace App\Http\Controllers;

use App\Models\Editora;
use Illuminate\Http\Request;

class EditoraController extends Controller
{
    /**
     * Display a listing of the editora.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $editoraQuery = Editora::query();
        $editoraQuery->where('name', 'like', '%'.request('q').'%');
        $editoras = $editoraQuery->paginate(25);

        return view('editoras.index', compact('editoras'));
    }

    /**
     * Show the form for creating a new editora.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Editora);

        return view('editoras.create');
    }

    /**
     * Store a newly created editora in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
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

        return redirect()->route('editoras.show', $editora);
    }

    /**
     * Display the specified editora.
     *
     * @param  \App\Models\Editora  $editora
     * @return \Illuminate\View\View
     */
    public function show(Editora $editora)
    {
        return view('editoras.show', compact('editora'));
    }

    /**
     * Show the form for editing the specified editora.
     *
     * @param  \App\Models\Editora  $editora
     * @return \Illuminate\View\View
     */
    public function edit(Editora $editora)
    {
        $this->authorize('update', $editora);

        return view('editoras.edit', compact('editora'));
    }

    /**
     * Update the specified editora in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Editora  $editora
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Editora $editora)
    {
        $this->authorize('update', $editora);

        $editoraData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $editora->update($editoraData);

        return redirect()->route('editoras.show', $editora);
    }

    /**
     * Remove the specified editora from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Editora  $editora
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Editora $editora)
    {
        $this->authorize('delete', $editora);

        $request->validate(['editora_id' => 'required']);

        if ($request->get('editora_id') == $editora->id && $editora->delete()) {
            return redirect()->route('editoras.index');
        }

        return back();
    }
}
