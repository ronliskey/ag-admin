<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resource - {{ $resource->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md mt-6">
        <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $resource->title }}</h1>

                <p class="font-bold text-gray-900 mb-2">{{ $resource->authors }}</p>

                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <span class="flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        
                        <div>{{ $resource->url }}</div>
                    </span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 items-end sm:items-center">
                <a href="{{ route('resources.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-md transition shadow-sm border border-gray-200">Back</a>
                <a href="{{ route('resources.edit', $resource) }}" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md shadow-sm transition">Edit Resource</a>
            </div>
        </div>


        <div>Summary: {{ $resource->summary }}</div>

        <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-wrap text-[17px]">Cats: {{ $resource->categories }}</div>
        <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-wrap text-[17px]">Tops: {{ $resource->topics }}</div>
        <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-wrap text-[17px]">Acts: {{ $resource->activities }}</div>
        <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-wrap text-[17px]">Opps: {{ $resource->opportunities }}</div>
        <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-wrap text-[17px]">Regs: {{ $resource->regions }}</div>
        <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-wrap text-[17px]">Lang: {{ $resource->language }}</div>

        <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-wrap text-[17px]">{{ $resource->content }}</div>

        <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:justify-between text-sm text-gray-500">
            <span>Created: {{ $resource->created_at->format('M d, Y H:i') }}</span>
            @if($resource->updated_at != $resource->created_at)
                <span>Updated: {{ $resource->updated_at->format('M d, Y H:i') }}</span>
            @endif
        </div>
    </div>
</body>
</html>