<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::paginate(10);
        $all_stat = Status::all();
        return view('Status.view', compact('statuses', 'all_stat'));
    }

    public function create()
    {
        return view('Status.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|max:255',
        ]);

        Status::create($data);

        return redirect()->route('statuses.index')
            ->with('success', 'Status created successfully.');
    }

    public function show(Status $status)
    {
        return view('Status.show', compact('status'));
    }

    public function edit(Status $status)
    {
        return view('Status.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $data = $request->validate([
            'description' => 'required|max:255',
        ]);

        $status->update($data);

        return redirect()->route('statuses.index')
            ->with('success', 'Status updated successfully.');
    }

    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('statuses.index')
            ->with('success', 'Status deleted successfully.');
    }
}
