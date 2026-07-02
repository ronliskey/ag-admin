<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Resource;
class ResourceController extends Controller
{
    // public function index()
    // {
    //     return view('add-resource');
    // }

    public function index()
    {
        $resources = Resource::latest()->paginate(10);
        return view('resources.index', compact('resources'));
    }

    public function store(Request $request)
    {
        $resource = new Resource;
        $resource->url = $request->url;
        $resource->title = $request->title;
        $resource->banner = $request->banner;
        $resource->summary = $request->summary;
        $resource->authors = $request->authors;
        $resource->categories = $request->categories;
        $resource->topics = $request->topics;
        $resource->activities = $request->activities;
        $resource->opportunities = $request->opportunities;
        $resource->regions = $request->regions;
        $resource->language = $request->language;
        $resource->content = $request->content;
        $resource->save();
        return redirect('add-resource')->with('status', 'Thank you. Accepted resources are published as soon as possible.');
    }


    public function create()
        {
            return view('resources.create');
        }

    public function show(Resource $resource)
    {
        return view('resource.show', compact('resource'));
    }

    public function edit(Resource $resource)
    {
        return view('resources.edit', compact('resources'));
    }

    public function update(Request $request, Resource $resource)
    {
        $request->merge([
            'slug' => Str::slug($request->title),
        ]);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:resources,slug,' . $resource->id . '|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,publish',
        ]);

        $resource->update($validatedData);

        return redirect()->route('resources.index')->with('success', 'Resource updated successfully.');
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('resources.index')->with('success', 'Resource deleted successfully.');
    }


}