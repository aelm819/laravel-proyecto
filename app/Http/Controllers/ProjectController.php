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
        $userId = Auth::id();

        $projects = Project::where('user_id', $userId)
            ->orWhereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->get();

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
        $validated = $this->validateProject($request);
        $validated['user_id'] = Auth::id();

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorizeAccess($project);

        $users = User::all();
        return view('projects.show', compact('project', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorizeOwner($project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorizeOwner($project);

        $validated = $this->validateProject($request);
        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorizeOwner($project);

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto eliminado correctamente.');
    }

    public function attachUser(Request $request, Project $project)
    {
        $this->authorizeOwner($project);

        $validated = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'role'               => 'required|string',
            'contribution_hours' => 'required|integer|min:1',
        ]);

        $project->users()->attach(
            $validated['user_id'],
            [
                'role'               => $validated['role'],
                'contribution_hours' => $validated['contribution_hours'],
            ]
        );

        return redirect()->route('projects.show', $project)
            ->with('success', 'Colaborador asignado al proyecto.');
    }

    public function detachUser(Project $project, User $user)
    {
        $this->authorizeOwner($project);

        $project->users()->detach($user->id);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Colaborador eliminado del proyecto.');
    }

    /**
     * Validate project fields shared between store and update.
     */
    private function validateProject(Request $request): array
    {
        return $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date',
            'status'      => 'required|string',
        ]);
    }

    /**
     * Ensure only the project creator can modify, delete, or manage collaborators.
     */
    private function authorizeOwner(Project $project): void
    {
        abort_unless($project->user_id === Auth::id(), 403);
    }

    /**
     * Ensure only the project creator or an assigned collaborator can view the project.
     */
    private function authorizeAccess(Project $project): void
    {
        $userId = Auth::id();
        $isCollaborator = $project->users()->where('users.id', $userId)->exists();

        abort_unless($project->user_id === $userId || $isCollaborator, 403);
    }
}
