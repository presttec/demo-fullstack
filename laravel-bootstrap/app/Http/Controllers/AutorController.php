<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use App\Http\Requests\AutorRequest;

class AutorController extends Controller
{
	
	protected function process_form(Request $request){
		$data = array();
		$data['nome'] = $request->input('nome');
		$data['biografia'] = $request->input('biografia');
		$data['ano_nascimento'] = $request->input('ano_nascimento');
		$data['sexo'] = $request->input('sexo');
		$data['nacionalidade'] = $request->input('nacionalidade');
		$data['quantidade'] = 0;
		return $data;
	}
	
	
    /**
     * Display a listing of the autor.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $autorQuery = Autor::query();
        $autorQuery->where('nome', 'like', '%'.request('q').'%');
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
    public function store(AutorRequest $request)
    {
        $this->authorize('create', new Autor);

        $newAutor = $this->process_form($request);
        $newAutor['creator_id'] = auth()->id();

        $autor = Autor::create($newAutor);

        return redirect()->route('autores.show', $autor);
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
    public function update(AutorRequest $request, Autor $autor)
    {
        $this->authorize('update', $autor);

        $autorData = $this->process_form($request);
        $autor->update($autorData);

        return redirect()->route('autores.show', $autor);
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
            return redirect()->route('autores.index');
        }

        return back();
    }
}
