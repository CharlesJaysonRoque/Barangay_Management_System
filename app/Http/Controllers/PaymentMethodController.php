<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_methods = PaymentMethod::paginate(10);
        $all_paym = PaymentMethod::all();
        return view('PaymentMethod.view', compact('payment_methods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('PaymentMethod.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'method' => 'required|max:255',
        ]);

        PaymentMethod::create([
            'method' => $request->method,
        ]);

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $payment_method)
    {
        return view('PaymentMethod.show', compact('payment_method'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $payment_method)
    {
        return view('PaymentMethod.edit', compact('payment_method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $payment_method)
    {
        $request->validate([
            'method' => 'required|max:255',
        ]);

        $payment_method->update($request->all());

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $payment_method)
    {
        $payment_method->delete();

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}
