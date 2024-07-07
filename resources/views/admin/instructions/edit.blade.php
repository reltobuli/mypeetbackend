@extends('layouts.app')

@section('title', 'Edit Instruction')

@section('content')
<div class="container">
    <header>
        <h1>Edit Instruction</h1>
    </header>

    <!-- Edit Instruction Form -->
    <div class="form-container">
        <form action="{{ route('admin.instructions.update', $instruction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="{{ $instruction->title }}" required>
            </div>
            
            <div class="form-group">
                <label for="details">Details:</label>
                <textarea id="details" name="details" required>{{ $instruction->details }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Instruction</button>
        </form>
    </div>
</div>
@endsection