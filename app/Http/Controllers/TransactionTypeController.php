<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use Illuminate\Http\Request;

class TransactionTypeController extends Controller
{
    public function index()
    {
        $transaction_types = TransactionType::paginate(10);
        $all_trant = TransactionType::all();
        return view('TransactionType.view', compact('transaction_types', 'all_trant'));
    }

    public function create()
    {
        return view('TransactionType.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|max:255',
        ]);

        TransactionType::create($data);

        return redirect()->route('transaction_types.index')
            ->with('success', 'Transaction type created successfully.');
    }

    public function show(TransactionType $transaction_type)
    {
        return view('TransactionType.show', compact('transaction_type'));
    }

    public function edit(TransactionType $transaction_type)
    {
        return view('TransactionType.edit', compact('transaction_type'));
    }

    public function update(Request $request, TransactionType $transaction_type)
    {
        $data = $request->validate([
            'description' => 'required|max:255',
        ]);

        $transaction_type->update($data);

        return redirect()->route('transaction_types.index')
            ->with('success', 'Transaction type updated successfully.');
    }

    public function destroy(TransactionType $transaction_type)
    {
        $transaction_type->delete();

        return redirect()->route('transaction_types.index')
            ->with('success', 'Transaction type deleted successfully.');
    }
}
