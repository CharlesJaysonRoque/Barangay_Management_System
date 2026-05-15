<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use App\Models\Resident;
use App\Models\Fine;
use App\Models\Status;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::with(['resident', 'fine', 'status'])->paginate(10);
        $all_viol = Violation::with(['resident', 'fine', 'status']);
        return view('Violation.view', compact('violations', 'all_viol'));
    }

    public function create()
    {
        return view('Violation.create', [
            'residents' => Resident::all(),
            'fines' => Fine::all(),
            'statuses' => Status::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fine_id' => 'required|exists:fines,id',
            'resident_id' => 'required|exists:residents,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        Violation::create($data);

        return redirect()->route('violations.index')
            ->with('success', 'Violation created successfully.');
    }

    public function show(Violation $violation)
    {
        $violation->load(['resident', 'fine', 'status']);
        return view('Violation.show', compact('violation'));
    }

    public function edit(Violation $violation)
    {
        return view('Violation.edit', [
            'violation' => $violation,
            'residents' => Resident::all(),
            'fines' => Fine::all(),
            'statuses' => Status::all(),
        ]);
    }

    public function update(Request $request, Violation $violation)
    {
        $data = $request->validate([
            'fine_id' => 'required|exists:fines,id',
            'resident_id' => 'required|exists:residents,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        $violation->update($data);

        return redirect()->route('violations.index')
            ->with('success', 'Violation updated successfully.');
    }

    public function destroy(Violation $violation)
    {
        $violation->delete();

        return redirect()->route('violations.index')
            ->with('success', 'Violation deleted successfully.');
    }
}
