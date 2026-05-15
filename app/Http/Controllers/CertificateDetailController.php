<?php

namespace App\Http\Controllers;

use App\Models\CertificateDetail;
use Illuminate\Http\Request;

class CertificateDetailController extends Controller
{
    public function index()
    {
        $certificate_details = CertificateDetail::paginate(10);
        $all_certd = CertificateDetail::all();
        return view('CertificateDetail.view', compact('certificate_details', 'all_certd'));
    }

    public function create()
    {
        return view('CertificateDetail.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'certificate_type_id' => 'required|integer|exists:certificate_types,id',
            'official_id' => 'required|integer|exists:officials,id',
        ]);

        CertificateDetail::create($data);

        return redirect()->route('certificate_details.index')
            ->with('success', 'Certificate detail created successfully.');
    }

    public function show(CertificateDetail $certificate_detail)
    {
        return view('CertificateDetail.show', compact('certificate_detail'));
    }

    public function edit(CertificateDetail $certificate_detail)
    {
        return view('CertificateDetail.edit', compact('certificate_detail'));
    }

    public function update(Request $request, CertificateDetail $certificate_detail)
    {
        $data = $request->validate([
            'certificate_type_id' => 'required|integer|exists:certificate_types,id',
            'official_id' => 'required|integer|exists:officials,id',
        ]);

        $certificate_detail->update($data);

        return redirect()->route('certificate_details.index')
            ->with('success', 'Certificate detail updated successfully.');
    }

    public function destroy(CertificateDetail $certificate_detail)
    {
        $certificate_detail->delete();

        return redirect()->route('certificate_details.index')
            ->with('success', 'Certificate detail deleted successfully.');
    }
}
