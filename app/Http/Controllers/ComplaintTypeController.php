<?php

namespace App\Http\Controllers;

use App\Models\ComplaintType;
use Illuminate\Http\Request;

class ComplaintTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaint_types = ComplaintType::paginate(10);
        $all_compt = ComplaintType::all();
        return view('ComplaintType.view', compact('complaint_types', 'all_compt'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ComplaintType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|max:255',
        ]);

        ComplaintType::create($request->all());

        return redirect()->route('complaint_types.index')
            ->with('success', 'Complaint type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComplaintType $complaint_type)
    {
        return view('ComplaintType.show', compact('complaint_type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComplaintType $complaint_type)
    {
        return view('ComplaintType.edit', compact('complaint_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComplaintType $complaint_type)
    {
        $request->validate([
            'description' => 'required|max:255',
        ]);

        $complaint_type->update($request->all());

        return redirect()->route('complaint_types.index')
            ->with('success', 'Complaint type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComplaintType $complaint_type)
    {
        $complaint_type->delete();

        return redirect()->route('complaint_types.index')
            ->with('success', 'Complaint type deleted successfully.');
    }
}
