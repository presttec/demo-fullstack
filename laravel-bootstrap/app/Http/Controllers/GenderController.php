<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    /**
     * Display a listing of the gender.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $genderQuery = Gender::query();
        $genderQuery->where('name', 'like', '%'.request('q').'%');
        $genders = $genderQuery->paginate(25);

        return view('genders.index', compact('genders'));
    }

    /**
     * Show the form for creating a new gender.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Gender);

        return view('genders.create');
    }

    /**
     * Store a newly created gender in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Gender);

        $newGender = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newGender['creator_id'] = auth()->id();

        $gender = Gender::create($newGender);

        return redirect()->route('genders.show', $gender);
    }

    /**
     * Display the specified gender.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\View\View
     */
    public function show(Gender $gender)
    {
        return view('genders.show', compact('gender'));
    }

    /**
     * Show the form for editing the specified gender.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\View\View
     */
    public function edit(Gender $gender)
    {
        $this->authorize('update', $gender);

        return view('genders.edit', compact('gender'));
    }

    /**
     * Update the specified gender in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Gender $gender)
    {
        $this->authorize('update', $gender);

        $genderData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $gender->update($genderData);

        return redirect()->route('genders.show', $gender);
    }

    /**
     * Remove the specified gender from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Gender $gender)
    {
        $this->authorize('delete', $gender);

        $request->validate(['gender_id' => 'required']);

        if ($request->get('gender_id') == $gender->id && $gender->delete()) {
            return redirect()->route('genders.index');
        }

        return back();
    }
}
