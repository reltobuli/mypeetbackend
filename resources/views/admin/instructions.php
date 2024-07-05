@extends('layouts.app')

@section('title', 'Manage Instructions')

@section('content')
<div class="container">
    <header>
        <h1>Manage Instructions</h1>
    </header>

    <!-- Add/Edit Instruction Form -->
    <div class="form-container">
        <form action="{{ isset($instruction) ? route('admin.instructions.update', $instruction->id) : route('admin.instructions.store') }}" method="POST">
            @csrf
            @if(isset($instruction))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="{{ isset($instruction) ? $instruction->title : old('title') }}" required>
            </div>
            
            <div class="form-group">
                <label for="details">Details:</label>
                <textarea id="details" name="details" required>{{ isset($instruction) ? $instruction->details : old('details') }}</textarea>
            </div>
            <button type="submit" class="button">{{ isset($instruction) ? 'Update' : 'Add' }} Instruction</button>
        </form>
        <button id="add-more" class="button">Add More</button>
    </div>

    <!-- List of Instructions -->
    @foreach ($instructions as $instruction)
        <div class="card">
            <h2>{{ $instruction->title }}</h2>
            
            <p>{{ $instruction->details }}</p>
            <a href="{{ route('admin.instructions.edit', $instruction->id) }}" class="button">Edit</a>
            <form action="{{ route('admin.instructions.delete', $instruction->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="button">Delete</button>
            </form>
        </div>
    @endforeach
</div>

<script>
    document.getElementById('add-more').addEventListener('click', function() {
        let formContainer = document.querySelector('.form-container');
        let form = formContainer.querySelector('form').cloneNode(true);
        form.reset();
        formContainer.appendChild(form);
    });
</script>
@endsection