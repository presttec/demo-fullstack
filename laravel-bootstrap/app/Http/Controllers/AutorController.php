<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    /**
     * Display a listing of the autor.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $autorQuery = Autor::query();
        $autorQuery->where('name', 'like', '%'.request('q').'%');
        $autors = $autorQuery->paginate(25);

        return view('autors.index', compact('autors'));
    }

    /**
     * Show the form for creating a new autor.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Autor);

        return view('autors.create');
    }

    /**
     * Store a newly created autor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
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

        return redirect()->route('autors.show', $autor);
    }

    /**
     * Display the specified autor.
     *
     * @param  \App\Models\Autor  $autor
     * @return \Illuminate\View\View
     */
    public function show(Autor $autor)
    {
        return view('autors.show', compact('autor'));
    }

    /**
     * Show the form for editing the specified autor.
     *
     * @param  \App\Models\Autor  $autor
     * @return \Illuminate\View\View
     */
    public function edit(Autor $autor)
    {
        $this->authorize('update', $autor);

        return view('autors.edit', compact('autor'));
    }

    /**
     * Update the specified autor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Autor  $autor
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Autor $autor)
    {
        $this->authorize('update', $autor);

        $autorData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $autor->update($autorData);

        return redirect()->route('autors.show', $autor);
    }

    /**
     * Remove the specified autor from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Autor  $autor
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Autor $autor)
    {
        $this->authorize('delete', $autor);

        $request->validate(['autor_id' => 'required']);

        if ($request->get('autor_id') == $autor->id && $autor->delete()) {
            return redirect()->route('autors.index');
        }

        return back();
    }
}
