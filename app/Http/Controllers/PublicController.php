<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // add this line of code
use App\Models\Resource;

class PublicController extends Controller
{
    
    // public function index()
    // {
    //     return view('add-resource');
    // }

     public function list()
    {
        $resources = Resource::latest()->paginate(10);
        return view('public.list', compact('resources'));
    }

    public function display(Resource $resource)
    {
        return view('public.display', compact('resource'));
    }


}