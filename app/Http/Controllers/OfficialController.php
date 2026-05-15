<?php

namespace App\Http\Controllers;

use App\Models\Official;
use Illuminate\Http\Request;

class OfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officials = Official::with('resident', 'official_title')->paginate(10);
        $all_off = Official::with('resident', 'official_title');
        return view('Official.view', compact('officials', 'all_off'));
    }

    public function create()
    {
        $residents = \App\Models\Resident::all();
        $official_titles = \App\Models\OfficialTitle::all();
        return view('Official.create', compact('residents', 'official_titles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'official_title_id' => 'required|exists:official_titles,id',
        ]);

        Official::create($request->all());

        return redirect()->route('officials.index')
            ->with('success', 'Official created successfully.');
    }

    public function show(Official $official)
    {
        $official->load('resident', 'official_title');
        return view('Official.show', compact('official'));
    }

    public function edit(Official $official)
    {
        $residents = \App\Models\Resident::all();
        $official_titles = \App\Models\OfficialTitle::all();
        return view('Official.edit', compact('official', 'residents', 'official_titles'));
    }

    public function update(Request $request, Official $official)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'official_title_id' => 'required|exists:official_titles,id',
        ]);

        $official->update($request->all());

        return redirect()->route('officials.index')
            ->with('success', 'Official updated successfully.');
    }

    public function destroy(Official $official)
    {
        $official->delete();

        return redirect()->route('officials.index')
            ->with('success', 'Official deleted successfully');
    }
}
