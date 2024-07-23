<!-- resources/views/filament/resources/cost-center-resource/view.blade.php -->

@extends('filament::layouts.app')

@section('content')
    <div class="p-4">
        <h2 class="text-xl font-bold">Cost Center Details</h2>
        <p><strong>ID:</strong> {{ $record->id }}</p>
        <p><strong>Name:</strong> {{ $record->name }}</p>
        <p><strong>Manager:</strong> {{ $record->manager }}</p>
        <p><strong>Email:</strong> {{ $record->email }}</p>
        <p><strong>Department:</strong> {{ $record->department }}</p>
        <p><strong>Created At:</strong> {{ $record->created_at }}</p>
        <p><strong>Updated At:</strong> {{ $record->updated_at }}</p>
    </div>
@endsection
