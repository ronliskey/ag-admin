<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ResourceController extends Controller
{
    // public function index()
    // {
    //     return view('add-resource');
    // }

    // https://qadrlabs.com/post/laravel-13-crud-tutorial-build-a-simple-blog-step-by-step

    public function index(): View
    {
        $resources = Resource::latest()->paginate(10);

        return view('resources.index', compact('resources'));
    }

    public function store(Request $request): RedirectResponse
    {
        // $request->merge([
        //     'slug' => Str::slug($request->title),
        // ]);

        $validatedData = $this->validatedResourceData($request);

        DB::transaction(function () use ($validatedData) {
            $resource = Resource::create(Arr::except($validatedData, 'links'));
            $resource->links()->createMany($validatedData['links'] ?? []);
        });

        return redirect()->route('resources.index')->with('success', 'Resource created successfully.');
        // return redirect('add-resource')->with('status', 'Thank you. Accepted resources are published as soon as possible.');
    }

    public function create(): View
    {
        return view('resources.create');
    }

    public function show(Resource $resource): View
    {
        $resource->load('links');

        return view('resources.show', compact('resource'));
    }

    public function edit(Resource $resource): View
    {
        $resource->load('links');

        return view('resources.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource): RedirectResponse
    {
        // $request->merge([
        //     'slug' => Str::slug($request->title),
        // ]);

        $validatedData = $this->validatedResourceData($request);

        DB::transaction(function () use ($resource, $validatedData) {
            $resource->update(Arr::except($validatedData, 'links'));
            $resource->links()->delete();
            $resource->links()->createMany($validatedData['links'] ?? []);
        });

        return redirect()->route('resources.index')->with('success', 'Resource updated successfully.');
    }

    public function destroy(Resource $resource): RedirectResponse
    {
        $resource->delete();

        return redirect()->route('resources.index')->with('success', 'Resource deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedResourceData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'banner' => ['nullable', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:255'],
            'authors' => ['nullable', 'string', 'max:255'],
            'categories' => ['nullable', 'string', 'max:255'],
            'topics' => ['nullable', 'string', 'max:255'],
            'activities' => ['nullable', 'string', 'max:255'],
            'opportunities' => ['nullable', 'string', 'max:255'],
            'regions' => ['nullable', 'string', 'max:255'],
            'language' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:512'],
            'links' => ['nullable', 'array', 'max:20'],
            'links.*.label' => ['required', 'string', 'max:80'],
            'links.*.url' => ['required', 'url', 'max:2048'],
        ]);
    }
}
