<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    public function index()
    {
        $project_types = ProjectType::paginate(10);
        $all_projt = ProjectType::all();
        return view('ProjectType.view', compact('project_types', 'all_projt'));
    }

    public function create()
    {
        return view('ProjectType.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|max:255',
        ]);

        ProjectType::create($data);

        return redirect()->route('project_types.index')
            ->with('success', 'Project type created successfully.');
    }

    public function show(ProjectType $project_type)
    {
        return view('ProjectType.show', compact('project_type'));
    }

    public function edit(ProjectType $project_type)
    {
        return view('ProjectType.edit', compact('project_type'));
    }

    public function update(Request $request, ProjectType $project_type)
    {
        $data = $request->validate([
            'description' => 'required|max:255',
        ]);

        $project_type->update($data);

        return redirect()->route('project_types.index')
            ->with('success', 'Project type updated successfully.');
    }

    public function destroy(ProjectType $project_type)
    {
        $project_type->delete();

        return redirect()->route('project_types.index')
            ->with('success', 'Project type deleted successfully.');
    }
}
