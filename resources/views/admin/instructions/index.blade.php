@extends('layouts.app')

@section('title', 'Manage Instructions')

@section('content')
<div class="container">
    <!-- Header -->
    <header class="text-center mb-4">
        <h1 class="h4">Manage Instructions</h1>
    </header>

    <!-- Add/Edit Instruction Form -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="form-container p-3 bg-light border rounded">
                <form action="{{ isset($instruction) ? route('admin.instructions.update', $instruction->id) : route('admin.instructions.store') }}" method="POST">
                    @csrf
                    @if(isset($instruction))
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" class="form-control form-control-sm" value="{{ isset($instruction) ? $instruction->title : old('title') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="details">Details:</label>
                        <textarea id="details" name="details" class="form-control form-control-sm" rows="3" required>{{ isset($instruction) ? $instruction->details : old('details') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">{{ isset($instruction) ? 'Update' : 'Add' }} Instruction</button>
                </form>
            </div>
        </div>
    </div>

    <!-- List of Instructions -->
    <div class="container">
    <!-- List of Instructions -->
    <div class="row justify-content-center mt-3">
        @foreach ($instructions as $instruction)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                <div class="card cute-card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $instruction->title }}</h5>
                        <p class="card-text">{{ $instruction->details }}</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.instructions.edit', $instruction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.instructions.delete', $instruction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection


