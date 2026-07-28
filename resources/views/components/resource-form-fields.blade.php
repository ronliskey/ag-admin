<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Title (using component view)</label>
    <input type="text" id="title" name="title" value="{{ old('title') }}" required 
        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
    <input type="text" id="url" name="url" value="{{ old('url') }}" required 
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
        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-y">{{ old('summary') }}</textarea>
</div>


<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Authors</label>
    <input type="text" id="authors" name="authors" value="{{ old('authors') }}"  
        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition">
</div>

                <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Categories</label>
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
        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-y">{{ old('content') }}</textarea>
</div>


<div class="pt-2 flex justify-end">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200 shadow-sm">
        Submit Resource
    </button>
</div>