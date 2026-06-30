<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Resource;
class ResourceController extends Controller
{
    public function index()
    {
        return view('add-resource');
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
        return redirect('add-resource')->with('status', 'Thank you. Accepted resources are posted as soon as possible.');
    }
}
