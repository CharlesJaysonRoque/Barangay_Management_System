<?php

namespace App\Http\Controllers;

use App\Models\CertificateType;
use Illuminate\Http\Request;

class CertificateTypeController extends Controller
{
    public function index()
    {
        $certificate_types = CertificateType::paginate(10);
        $all_certt = CertificateType::all();
        return view('CertificateType.view', compact('certificate_types', 'all_certt'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('CertificateType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|max:255',
        ]);

        CertificateType::create($request->all());

        return redirect()->route('certificate_types.index')
            ->with('success', 'Certificate type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CertificateType $certificate_type)
    {
        return view('CertificateType.view', compact('certificate_type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CertificateType $certificate_type)
    {
        return view('CertificateType.edit', compact('certificate_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CertificateType $certificate_type)
    {
        $request->validate([
            'description' => 'required|max:255',
        ]);

        $certificate_type->update($request->all());

        return redirect()->route('certificate_types.index')
            ->with('success', 'Certificate type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificateType $certificate_type)
    {
        $certificate_type->delete();

        return redirect()->route('certificate_types.index')
            ->with('success', 'Certificate type deleted successfully.');
    }
}
