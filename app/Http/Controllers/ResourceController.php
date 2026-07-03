<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // add this line of code
use App\Models\Resource;

class ResourceController extends Controller
{
    // public function index()
    // {
    //     return view('add-resource');
    // }

    // https://qadrlabs.com/post/laravel-13-crud-tutorial-build-a-simple-blog-step-by-step  

    public function index()
    {
        $resources = Resource::latest()->paginate(10);
        return view('resources.index', compact('resources'));
    }

    public function store(Request $request)
    {
        // $request->merge([
        //     'slug' => Str::slug($request->title),
        // ]);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|max:255',
            'banner' => 'max:255',
            'summary' => 'required|max:255',
            'authors' => 'max:255',
            'categories' => 'max:255',
            'topics' => 'max:255',
            'activities' => 'max:255',
            'opportunities' => 'max:255',
            'regions' => 'max:255',
            'language' => 'max:255',
            'content' => 'max:512'
        ]);

        Resource::create($validatedData);

        return redirect()->route('resources.index')->with('success', 'Resource created successfully.');
        // return redirect('add-resource')->with('status', 'Thank you. Accepted resources are published as soon as possible.');
    }


    public function create()
        {
            return view('resources.create');
        }

    public function show(Resource $resource)
    {
        return view('resources.show', compact('resource'));
    }

    public function edit(Resource $resource)
    {
        return view('resources.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        // $request->merge([
        //     'slug' => Str::slug($request->title),
        // ]);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|max:255',
            'banner' => 'max:255',
            'summary' => 'required|max:255',
            'authors' => 'max:255',
            'categories' => 'max:255',
            'topics' => 'max:255',
            'activities' => 'max:255',
            'opportunities' => 'max:255',
            'regions' => 'max:255',
            'language' => 'max:255',
            'content' => 'max:512'
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