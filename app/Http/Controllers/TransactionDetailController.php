<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\TransactionType;
use App\Models\PaymentMethod;
use App\Models\Status;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    public function index()
    {
        $transaction_details = TransactionDetail::with([
            'transactionType',
            'paymentMethod',
            'status'
        ])->paginate(10);
        $transaction_types = TransactionType::all()->keyBy('id');
        $statuses = Status::all()->keyBy('id');
        $all_trand = TransactionDetail::all();

        return view('TransactionDetail.view', compact('transaction_details', 'transaction_types', 'statuses', 'all_trand'));
    }

    public function create()
    {
        return view('TransactionDetail.create', [
            'transaction_types' => TransactionType::all(),
            'payment_methods' => PaymentMethod::all(),
            'statuses' => Status::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'status_id' => 'required|exists:statuses,id',
            'amount' => 'required|integer|min:0',
            'transaction_date' => 'required|date',
        ]);

        TransactionDetail::create($data);

        return redirect()->route('transaction_details.index')
            ->with('success', 'Transaction detail created successfully.');
    }

    public function show(TransactionDetail $transaction_detail)
    {
        $transaction_detail->load(['transactionType', 'paymentMethod', 'status']);

        return view('TransactionDetail.show', compact('transaction_detail'));
    }

    public function edit(TransactionDetail $transaction_detail)
    {
        return view('TransactionDetail.edit', [
            'transaction_detail' => $transaction_detail,
            'transaction_types' => TransactionType::all(),
            'payment_methods' => PaymentMethod::all(),
            'statuses' => Status::all(),
        ]);
    }

    public function update(Request $request, TransactionDetail $transaction_detail)
    {
        $data = $request->validate([
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'status_id' => 'required|exists:statuses,id',
            'amount' => 'required|integer|min:0',
            'transaction_date' => 'required|date',
        ]);

        $transaction_detail->update($data);

        return redirect()->route('transaction_details.index')
            ->with('success', 'Transaction detail updated successfully.');
    }

    public function destroy(TransactionDetail $transaction_detail)
    {
        $transaction_detail->delete();

        return redirect()->route('transaction_details.index')
            ->with('success', 'Transaction detail deleted successfully.');
    }
}
