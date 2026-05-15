<?php

namespace App\Http\Controllers;

use App\Models\OfficialTitle;
use Illuminate\Http\Request;

class OfficialTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $official_titles = OfficialTitle::paginate(10);
        $all_offt = OfficialTitle::all();
        return view('OfficialTitle.view', compact('official_titles', 'all_offt'));
    }

    public function create()
    {
        return view('OfficialTitle.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'term_validity' => 'required|integer|min:0',
            'max_term' => 'required|integer|min:0',
            'title' => 'required|max:255',
        ]);

        OfficialTitle::create($request->all());

        return redirect()->route('official_titles.index')
            ->with('success', 'Official title created successfully.');
    }

    public function show(OfficialTitle $official_title)
    {
        return view('OfficialTitle.show', compact('official_title'));
    }

    public function edit(OfficialTitle $official_title)
    {
        return view('OfficialTitle.edit', compact('official_title'));
    }

    public function update(Request $request, OfficialTitle $official_title)
    {
        $request->validate([
            'term_validity' => 'required|integer|min:0',
            'max_term' => 'required|integer|min:0',
            'title' => 'required|max:255',
        ]);

        $official_title->update($request->all());

        return redirect()->route('official_titles.index')
            ->with('success', 'Official title updated successfully.');
    }

    public function destroy(OfficialTitle $official_title)
    {
        $official_title->delete();

        return redirect()->route('official_titles.index')
            ->with('success', 'Official title deleted successfully.');
    }
}
