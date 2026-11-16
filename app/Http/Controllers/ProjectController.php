<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date',
            'status'      => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();

        Project::create($validated);
        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $users = User::all();
        return view('projects.show', compact('project', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date',
            'status'      => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();

        $project->update($validated);
        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index');
    }

    public function attachUser(Request $request, Project $project)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role'    => 'required|string',
            'contribution_hours' => 'required|integer|min:1',
        ]);

        $project->users()->attach(
            $validated['user_id'],
            [
                'role' => $validated['role'],
                'contribution_hours' => $validated['contribution_hours']
            ]
        );

        // $project->users()->syncWithoutDetaching([
        //     $validated['user_id'] => [
        //         'role' => $validated['role'],
        //         'contribution_hours' => $validated['contribution_hours'],
        //     ]
        // ]);
        return redirect()->route('projects.show', $project);
    }

    public function detachUser(Project $project, User $user)
    {
        $project->users()->detach($user->id);
        return redirect()->route('projects.show', $project);
    }
}
