@php
    $linkRows = old(
        'links',
        isset($resource)
            ? $resource->links->map(fn ($link) => ['label' => $link->label, 'url' => $link->url])->all()
            : [],
    );
@endphp

<div>
    <div class="mb-2 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Additional Links</h2>
            <p class="text-sm text-gray-600">Add labeled links such as Donate, Volunteer, or Issues.</p>
        </div>
        <button type="button" id="add-link" class="rounded-md bg-gray-800 px-3 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
            Add Link
        </button>
    </div>

    <div id="additional-links" class="space-y-3">
        @foreach($linkRows as $index => $link)
            <div class="grid gap-3 rounded-md border border-gray-200 bg-gray-50 p-3 md:grid-cols-[1fr_2fr_auto]" data-link-row>
                <input
                    type="text"
                    name="links[{{ $index }}][label]"
                    value="{{ $link['label'] ?? '' }}"
                    maxlength="80"
                    placeholder="Label, e.g. Donate"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 outline-none transition focus:border-blue-500 focus:ring-blue-500">
                <input
                    type="url"
                    name="links[{{ $index }}][url]"
                    value="{{ $link['url'] ?? '' }}"
                    maxlength="2048"
                    placeholder="https://..."
                    class="w-full rounded-md border border-gray-300 px-3 py-2 outline-none transition focus:border-blue-500 focus:ring-blue-500">
                <button type="button" class="remove-link rounded-md border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50">Remove</button>
            </div>
        @endforeach
    </div>

    <template id="link-row-template">
        <div class="grid gap-3 rounded-md border border-gray-200 bg-gray-50 p-3 md:grid-cols-[1fr_2fr_auto]" data-link-row>
            <input
                type="text"
                name="links[__INDEX__][label]"
                maxlength="80"
                placeholder="Label, e.g. Donate"
                class="w-full rounded-md border border-gray-300 px-3 py-2 outline-none transition focus:border-blue-500 focus:ring-blue-500">
            <input
                type="url"
                name="links[__INDEX__][url]"
                maxlength="2048"
                placeholder="https://..."
                class="w-full rounded-md border border-gray-300 px-3 py-2 outline-none transition focus:border-blue-500 focus:ring-blue-500">
            <button type="button" class="remove-link rounded-md border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50">Remove</button>
        </div>
    </template>
</div>

<script>
    (() => {
        const list = document.querySelector('#additional-links');
        const addButton = document.querySelector('#add-link');
        const template = document.querySelector('#link-row-template');
        let nextIndex = {{ count($linkRows) }};

        addButton.addEventListener('click', () => {
            const row = template.content.cloneNode(true);

            row.querySelectorAll('[name]').forEach((input) => {
                input.name = input.name.replace('__INDEX__', nextIndex);
            });

            list.appendChild(row);
            nextIndex += 1;
        });

        list.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-link')) {
                event.target.closest('[data-link-row]').remove();
            }
        });
    })();
</script>
