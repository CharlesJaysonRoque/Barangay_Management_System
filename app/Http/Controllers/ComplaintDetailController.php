<?php

namespace App\Http\Controllers;

use App\Models\ComplaintDetail;
use App\Models\Resident;
use App\Models\ComplaintType;
use App\Models\Status;
use Illuminate\Http\Request;

class ComplaintDetailController extends Controller
{
    public function index()
    {
        $complaint_details = ComplaintDetail::with([
            'complainant',
            'accused',
            'complaintType',
            'status'
        ])->paginate(10);
        $all_compd = ComplaintDetail::all();

        return view('ComplaintDetail.view', compact('complaint_details', 'all_compd'));
    }

    public function create()
    {
        $residents = Resident::all();
        $complaint_types = ComplaintType::all();
        $statuses = Status::all();

        return view('ComplaintDetail.create', compact('residents', 'complaint_types', 'statuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'complainant_id' => 'required|exists:residents,id',
            'accused_id' => 'required|exists:residents,id',
            'complaint_type_id' => 'required|exists:complaint_types,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        ComplaintDetail::create($data);

        return redirect()->route('complaint_details.index')
            ->with('success', 'Complaint detail created successfully.');
    }

    public function show(ComplaintDetail $complaint_detail)
    {
        $complaint_detail->load([
            'complainant',
            'accused',
            'complaintType',
            'status'
        ]);

        return view('ComplaintDetail.show', compact('complaint_detail'));
    }

    public function edit(ComplaintDetail $complaint_detail)
    {
        $residents = Resident::all();
        $complaint_types = ComplaintType::all();
        $statuses = Status::all();

        return view('ComplaintDetail.edit', compact(
            'complaint_detail',
            'residents',
            'complaint_types',
            'statuses'
        ));
    }

    public function update(Request $request, ComplaintDetail $complaint_detail)
    {
        $data = $request->validate([
            'complainant_id' => 'required|exists:residents,id',
            'accused_id' => 'required|exists:residents,id',
            'complaint_type_id' => 'required|exists:complaint_types,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        $complaint_detail->update($data);

        return redirect()->route('complaint_details.index')
            ->with('success', 'Complaint detail updated successfully.');
    }

    public function destroy(ComplaintDetail $complaint_detail)
    {
        $complaint_detail->delete();

        return redirect()->route('complaint_details.index')
            ->with('success', 'Complaint detail deleted successfully.');
    }
}
