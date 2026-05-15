<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index()
    {
        $fines = Fine::paginate(10);
        $all_fine = Fine::all();
        return view('Fine.view', compact('fines', 'all_fine'));
    }

    public function create()
    {
        return view('Fine.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|integer|min:0',
            'description' => 'required|max:255',
        ]);

        Fine::create($data);

        return redirect()->route('fines.index')
            ->with('success', 'Fine created successfully.');
    }

    public function show(Fine $fine)
    {
        return view('Fine.show', compact('fine'));
    }

    public function edit(Fine $fine)
    {
        return view('Fine.edit', compact('fine'));
    }

    public function update(Request $request, Fine $fine)
    {
        $data = $request->validate([
            'amount' => 'required|integer|min:0',
            'description' => 'required|max:255',
        ]);

        $fine->update($data);

        return redirect()->route('fines.index')
            ->with('success', 'Fine updated successfully.');
    }

    public function destroy(Fine $fine)
    {
        $fine->delete();

        return redirect()->route('fines.index')
            ->with('success', 'Fine deleted successfully.');
    }
}
