@extends('layouts.app')

@section('title', 'Shelter Management')

@section('content')
<div class="container">
    <h1>Manage Shelters</h1>
    <div class="form-container">
        <form action="{{ route('admin.shelters.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="capacity">Capacity:</label>
                <input type="number" id="capacity" name="capacity" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
            </div>
            <button type="submit" class="button">Add Shelter</button>
        </form>
    </div>

    <!-- List of Shelters -->
    <div class="row">
    @foreach ($shelters as $shelter)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="cute-card">
                <div class="card-body">
                    <h2 class="card-title">{{ $shelter->name }}</h2>
                    <p class="card-text">Location: {{ $shelter->location }}</p>
                    <p class="card-text">Capacity: {{ $shelter->capacity }} animals</p>
                    <p class="card-text">Address: {{ $shelter->address }}</p>
                    <p class="card-text">Phone Number: {{ $shelter->phone_number }}</p>
                    <p class="card-text">City: {{ $shelter->city }}</p>
                    <a href="{{ route('admin.shelters.edit', $shelter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.shelters.delete', $shelter->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>


