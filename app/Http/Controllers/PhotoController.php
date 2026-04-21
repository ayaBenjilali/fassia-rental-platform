<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'objet_louable_id' => 'required|exists:objet_louables,id',
        ]);

        $path = $request->file('url_photo')->store('photos', 'public');
        $validated['url_photo'] = '/storage/' . $path;

        Photo::create($validated);

        return back()->with('success', 'Photo ajoutée.');
    }

    public function show(Photo $photo)
    {
        //
    }

    public function edit(Photo $photo)
    {
        //
    }

    public function update(Request $request, Photo $photo)
    {
        //
    }

    public function destroy(Photo $photo)
    {
        // Delete physical file from storage
        if ($photo->url_photo) {
            // Remove /storage/ prefix if present
            $path = str_replace('/storage/', '', $photo->url_photo);
            Storage::disk('public')->delete($path);
        }

        $photo->delete();
        return back()->with('success', 'Photo retirée.');
    }
}
