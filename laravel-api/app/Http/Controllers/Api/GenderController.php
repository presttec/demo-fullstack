<?php

namespace App\Http\Controllers\Api;

use App\Models\Gender;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    /**
     * Get a listing of the gender.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $genderQuery = Gender::query();
        $genderQuery->where('name', 'like', '%'.request('q').'%');
        $genders = $genderQuery->paginate(25);

        return $genders;
    }

    /**
     * Store a newly created gender in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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

        return response()->json([
            'message' => __('gender.created'),
            'data'    => $gender,
        ], 201);
    }

    /**
     * Get the specified gender.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Gender $gender)
    {
        return $gender;
    }

    /**
     * Update the specified gender in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Gender $gender)
    {
        $this->authorize('update', $gender);

        $genderData = $request->validate([
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $gender->update($genderData);

        return response()->json([
            'message' => __('gender.updated'),
            'data'    => $gender,
        ]);
    }

    /**
     * Remove the specified gender from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Gender $gender)
    {
        $this->authorize('delete', $gender);

        $request->validate(['gender_id' => 'required']);

        if ($request->get('gender_id') == $gender->id && $gender->delete()) {
            return response()->json(['message' => __('gender.deleted')]);
        }

        return response()->json('Unprocessable Entity.', 422);
    }
}
