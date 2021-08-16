<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    /**
     * Display a listing of the genero.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $generoQuery = Genero::query();
        $generoQuery->where('nome', 'like', '%'.request('q').'%');
        $generos = $generoQuery->paginate(25);

        return view('generos.index', compact('generos'));
    }

    /**
     * Show the form for creating a new genero.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Genero);

        return view('generos.create');
    }

    /**
     * Store a newly created genero in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Genero);

        $newGenero = $request->validate([
            'nome'        => 'required|max:60',
            'descricao' => 'nullable|max:255',
        ]);
        $newGenero['creator_id'] = auth()->id();
        $newGenero['quantidade'] = 0;

        $genero = Genero::create($newGenero);

        return redirect()->route('generos.show', $genero);
    }

    /**
     * Display the specified genero.
     *
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\View\View
     */
    public function show(Genero $genero)
    {
        return view('generos.show', compact('genero'));
    }

    /**
     * Show the form for editing the specified genero.
     *
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\View\View
     */
    public function edit(Genero $genero)
    {
        $this->authorize('update', $genero);

        return view('generos.edit', compact('genero'));
    }

    /**
     * Update the specified genero in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Genero $genero)
    {
        $this->authorize('update', $genero);

        $generoData = $request->validate([
            'nome'        => 'required|max:60',
            'descricao' => 'nullable|max:255',
        ]);
        $genero->update($generoData);

        return redirect()->route('generos.show', $genero);
    }

    /**
     * Remove the specified genero from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genero  $genero
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Genero $genero)
    {
        $this->authorize('delete', $genero);

        $request->validate(['genero_id' => 'required']);

        if ($request->get('genero_id') == $genero->id && $genero->delete()) {
            return redirect()->route('generos.index');
        }

        return back();
    }
}
