<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $residents = Resident::paginate(10);
        $all_res = Resident::all();
        return view('Resident.view', compact('residents', 'all_res'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Resident.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'firstname' => 'required|max:255',
        'middlename' => 'nullable|max:255',
        'lastname' => 'required|max:255',
        'contact_number' => 'required|max:255',
        'street' => 'required|max:255',
        'house_number' => 'required|max:255',
    ]);

    $exists = Resident::where('firstname', $request->firstname)
        ->where('lastname', $request->lastname)
        ->where('house_number', $request->house_number)
        ->where('street', $request->street)
        ->exists();

    if ($exists) {
        return back()->with('error', 'Resident already exists.');
    }

    Resident::create($request->all());

    return redirect()->route('residents.index')
        ->with('success', 'Resident created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(Resident $resident)
    {
        return view('Resident.resident.show', compact('resident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resident $resident)
    {
        return view('Resident.edit', compact('resident'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resident $resident)
    {
        $request->validate([
            'firstname' => 'required|max:255',
            'middlename' => 'nullable|max:255',
            'lastname' => 'required|max:255',
            'contact_number' => 'required|max:255',
            'street' => 'required|max:255',
            'house_number' => 'required|max:255',
        ]);

        $resident->update($request->all());

        return redirect()->route('residents.index')
            ->with('success', 'Resident updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident)
    {
        $resident->delete();

        return redirect()->route('residents.index')
            ->with('success', 'Resident deleted successfully.');
    }
}
