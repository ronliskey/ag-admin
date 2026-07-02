<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // add this line of code

class ResourceController extends Controller
{
    // ... [other lines of code]

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'slug' => Str::slug($request->title),
        ]);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:resources,slug|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,publish',
        ]);

        Resource::create($validatedData);

        return redirect()->route('resources.index')->with('success', 'Resource created successfully.');
    }

    // ... [other lines of code]
}