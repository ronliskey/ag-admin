<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class ResourceController extends Controller
{

    public function store(Request $request)
    {
        // $request->merge([
        //     'slug' => Str::slug($request->title),
        // ]);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|max:255',
            'banner' => 'max:255',
            'summary' => 'required|max:512',
            'categories' => 'max:255',
            'topics' => 'max:255',
            'activities' => 'max:255',
            'opportunities' => 'max:255',
            'regions' => 'max:255',
            'language' => 'max:255',
            'content' => 'max:512',
        ]);

        Resource::create($validatedData);

        return redirect()->route('resources.index')->with('success', 'Resource created successfully.');
    }

    // ... [other lines of code]
}