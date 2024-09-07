<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Contact;


class ProjectController extends Controller
{
    public function index( Request $request)
    {   
        $query = Project::query()
            -> withCount('contacts');

        if ($request->has('status') && $request->status !== '' && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $projects = $query->paginate(10);

        return view('projects.index', compact('projects'));
        
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:projects',
            'description' => 'required',
            'status' => 'required|in:fejlesztésre vár,folyamatban,kész',
            'contacts' => 'required|array|min:1', 
            'contacts.*.name' => 'required|string|max:20|min:3',
            'contacts.*.email' => 'required|email',
        ], [
            'name.unique' => 'A projekt már létezik!',
            'contacts.min' => 'Legalább egy kapcsolattartó megadása kötelező.', 
        ]);
    
        $existingProject = Project::where('name', $request->name)->first();
        if ($existingProject) {
            return redirect()->route('projects.create')
                ->with('error', 'A projekt már létezik!');
        }
    
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    
        foreach ($request->contacts as $contactData) {
            $project->contacts()->create($contactData);
        }
    
        return redirect()->route('projects.index')
            ->with('success', 'Projekt sikeresen létrehozva.');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required|in:fejlesztésre vár,folyamatban,kész',
            'contacts.*.name' => 'required|string|max:20|min:3',
            'contacts.*.email' => 'required|email',
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        

        $project->contacts()->delete();

        foreach ($request->contacts as $contactData) {
            $project->contacts()->create($contactData);
        }

        $project->update($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Projekt sikeresen frissítve.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('projects.index')
            ->with('success', 'Projekt sikeresen törölve.');
    }
}
