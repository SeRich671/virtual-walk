<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        auth()->user()->projects()->create($request->validated());

        return redirect()->route('dashboard')->with('success', 'Project was successfully stored');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('dashboard')->with('success', 'Project was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project was successfully deleted');
    }

    public function publish(Project $project): RedirectResponse
    {
        $project->update([
            'share_url' => Str::uuid()
        ]);

        return redirect()->back()->with('success', 'Project was successfully published');
    }

    public function hide(Project $project): RedirectResponse
    {
        $project->update([
            'share_url' => null
        ]);

        return redirect()->back()->with('success', 'Project was successfully hidden');
    }

    public function show($shareUrl) {
        $project = Project::where('share_url', $shareUrl)->first();

        $photo = $project?->photos()->first();

        return view('welcome', compact('photo'));
    }
}
