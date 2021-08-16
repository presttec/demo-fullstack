<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    /**
     * Display a listing of the livro.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $livroQuery = Livro::query();
        $livroQuery->where('name', 'like', '%'.request('q').'%');
        $livros = $livroQuery->paginate(25);

        return view('livros.index', compact('livros'));
    }

    /**
     * Show the form for creating a new livro.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Livro);

        return view('livros.create');
    }

    /**
     * Store a newly created livro in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
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

        return redirect()->route('livros.show', $livro);
    }

    /**
     * Display the specified livro.
     *
     * @param  \App\Models\Livro  $livro
     * @return \Illuminate\View\View
     */
    public function show(Livro $livro)
    {
        return view('livros.show', compact('livro'));
    }

    /**
     * Show the form for editing the specified livro.
     *
     * @param  \App\Models\Livro  $livro
     * @return \Illuminate\View\View
     */
    public function edit(Livro $livro)
    {
        $this->authorize('update', $livro);

        return view('livros.edit', compact('livro'));
    }

    /**
     * Update the specified livro in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Livro  $livro
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Livro $livro)
    {
        $this->authorize('update', $livro);

        $livroData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $livro->update($livroData);

        return redirect()->route('livros.show', $livro);
    }

    /**
     * Remove the specified livro from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Livro  $livro
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Livro $livro)
    {
        $this->authorize('delete', $livro);

        $request->validate(['livro_id' => 'required']);

        if ($request->get('livro_id') == $livro->id && $livro->delete()) {
            return redirect()->route('livros.index');
        }

        return back();
    }
}
