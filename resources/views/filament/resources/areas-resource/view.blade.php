<x-filament::page>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">{{ $record->name }}</h1>
        <a href="{{ route('filament.resources.areas.edit', $record) }}" class="btn btn-primary">Edit</a>
    </div>

    <div class="mt-4">
        <p><strong>Created At:</strong> {{ $record->created_at->format('Y-m-d H:i:s') }}</p>
        <p><strong>Updated At:</strong> {{ $record->updated_at->format('Y-m-d H:i:s') }}</p>
        <!-- Add more details here -->
    </div>

    <!-- Add additional content or layout customization here -->
</x-filament::page>
