<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resource - {{ $resource->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Resource</h1>
            <a href="{{ route('resources.index') }}" class="text-gray-600 hover:text-gray-900 underline text-sm transition">Back to Manage Resources</a>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('resources.update', $resource) }}" method="POST" class="space-y-6">
            @csrf

            <!-- 
                @method('PUT') adds a hidden field that tells Laravel to treat this 
                form submission as a PUT request, which maps to the update() controller method. 
            -->
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $resource->title) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                <input type="text" id="url" name="url" value="{{ old('url', $resource->url) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Banner</label>
                <input type="text" id="banner" name="banner" value="{{ old('banner') }}"  
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Summary</label>
                <textarea name="summary" rows="8" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-y">{{ old('summary', $resource->summary) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Authors</label>
                <input type="text" id="authors" name="authors" value="{{ old('authors') }}"  
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categories</label>

                <div style="margin: 0 0 1em 2em">
                    <label>
                        <input type="checkbox" 
                            name="categories-choose[]" 
                            value="Environmental Sustainability"> Environmental Sustainability
                    </label> <br>

                    <label>
                        <input type="checkbox" 
                            name="categories-choose[]" 
                            value="Social Justice"> Social Justice
                    </label><br>

                    <label>
                        <input type="checkbox" 
                            name="categories-choose[]" 
                            value="Democracy and Elections"> Democracy and Elections
                    </label><br>

                    <label>
                        <input type="checkbox" 
                            name="categories-choose[]" 
                            value="News and Analysis"> News and Analysis
                    </label><br>

                    <label>
                        <input type="checkbox" 
                            name="categories-choose[]" 
                            value="Strategy, Tactics and Tools"> Strategy, Tactics and Tools
                    <label>
                </div>
            <div>

                 <label class="block text-sm font-medium text-gray-700 mb-1">Additional Categories (separate with commas)</label>
                    
                <input type="text" id="categories" name="categories" value="{{ old('categories') }}"  
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Topics</label>
                <input type="text" id="topics" name="topics" value="{{ old('topics') }}"  
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Activities</label>
                <input type="text" id="activities" name="activities" value="{{ old('activities') }}"  
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Opportunities</label>
                <input type="text" id="opportunities" name="opportunities" value="{{ old('opportunities') }}"  
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Regions</label>
                <input type="text" id="regions" name="regions" value="{{ old('regions') }}"  
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                <input type="text" id="language" name="language" value="{{ old('language') }}"  
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea name="content" rows="8"  
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-y">{{ old('content', $resource->content) }}</textarea>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200 shadow-sm">
                    Update Resource
                </button>
            </div>
        </form>
    </div>
</body>
</html>