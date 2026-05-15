<?php

namespace App\Http\Controllers;

use App\Models\ProjectDetail;
use App\Models\ProjectType;
use App\Models\Status;
use Illuminate\Http\Request;

class ProjectDetailController extends Controller
{
    public function index()
    {
        $project_details = ProjectDetail::with(['projectType', 'status'])->paginate(10);
        $all_projd = ProjectDetail::with(['projectType', 'status']);
        return view('ProjectDetail.view', compact('project_details', 'all_projd'));
    }

    public function create()
    {
        $project_types = ProjectType::all();
        $statuses = Status::all();

        return view('ProjectDetail.create', compact('project_types', 'statuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'description' => 'required|max:255',
            'start_date' => 'required|date',
            'tentative_end_date' => 'required|date|after_or_equal:start_date',
            'actual_end_date' => 'nullable|date',
            'budget' => 'required|integer|min:0',
            'status_id' => 'required|exists:statuses,id',
        ]);

        ProjectDetail::create($data);

        return redirect()->route('project_details.index')
            ->with('success', 'Project detail created successfully.');
    }

    public function show(ProjectDetail $project_detail)
    {
        $project_detail->load(['projectType', 'status']);
        return view('ProjectDetail.show', compact('project_detail'));
    }

    public function edit(ProjectDetail $project_detail)
    {
        return view('ProjectDetail.edit', [
            'project_detail' => $project_detail,
            'project_types' => ProjectType::all(),
            'statuses' => Status::all(),
        ]);
    }

    public function update(Request $request, ProjectDetail $project_detail)
    {
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'description' => 'required|max:255',
            'start_date' => 'required|date',
            'tentative_end_date' => 'required|date|after_or_equal:start_date',
            'actual_end_date' => 'nullable|date',
            'budget' => 'required|integer|min:0',
            'status_id' => 'required|exists:statuses,id',
        ]);

        $project_detail->update($data);

        return redirect()->route('project_details.index')
            ->with('success', 'Project detail updated successfully.');
    }

    public function destroy(ProjectDetail $project_detail)
    {
        $project_detail->delete();

        return redirect()->route('project_details.index')
            ->with('success', 'Project detail deleted successfully.');
    }
}
