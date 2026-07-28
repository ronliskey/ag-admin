<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Resource</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Create Resource</h1>
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

        <div class="bg-blue-50 border border-blue-200 text-blue-600 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside text-sm">
                <li>Using: views/resources/create</li>
            </ul>
        </div>

        <form action="{{ route('resources.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-resource-form-fields />

        </form>
    </div>
</body>
</html>