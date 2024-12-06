<?php

namespace App\Http\Controllers;

use App\Http\Requests\Photo\StoreRequest;
use App\Http\Requests\Photo\UpdateRequest;
use App\Models\Photo;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $photos = $project->photos()->paginate(12);

        return view('photo.index', compact('photos', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('photo.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, Project $project)
    {
        $uuid = (string) Str::uuid();
        $extension = $request->file('image')->getClientOriginalExtension();

        $customPath = "project/{$project->id}/photos/{$uuid}.{$extension}";

        $path = $request->file('image')->storeAs(dirname($customPath), basename($customPath), 'public');

        $photo = $project->photos()->create([
            'uuid' => $uuid,
            'url' => Storage::url($path),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('project.photo.index', $project)->with('success', 'Photo was successfully stored');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Photo $photo)
    {
        $otherPhotos = $project->photos()->where('id', '!=', $photo->id)->get();

        return view('photo.edit', compact('photo', 'project', 'otherPhotos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Project $project, Photo $photo): RedirectResponse
    {
        $photo->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        $movements = [];

        foreach ($request->movements ?? [] as $movement) {
            if (!empty($movement['photo_id'])) {
                $movements[$movement['photo_id']] = ['angle' => $movement['value'] ?? null];
            }
        }

        $photo->movements()->sync($movements);

        return redirect()->route('project.photo.index', $project)->with('success', 'Photo was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Photo $photo)
    {
        $photo->delete();

        return redirect()->route('project.photo.index', $project)->with('success', 'Photo was successfully deleted');
    }
}
