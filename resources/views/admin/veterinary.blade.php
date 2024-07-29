@extends('layouts.app')

@section('title', 'Veterinary Management')

@section('content')
<div class="container">
    <header class="mb-4">
        <h1>Manage Veterinary Centers</h1>
    </header>

    <!-- Add/Edit Veterinary Center Form -->
    <div class="form-container mb-4">
        <form action="{{ isset($veterinaryCenter) ? route('admin.veterinary.update', $veterinaryCenter->id) : route('admin.veterinary.store') }}" method="POST">
            @csrf
            @if(isset($veterinaryCenter))
                @method('PUT')
            @endif
            <div class="form-group mb-3">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->name : old('name') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="phone_number">Phone:</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->phone_number : old('phone_number') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="rating">Rating:</label>
                <input type="number" id="rating" name="rating" class="form-control" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->rating : old('rating') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->city : old('city') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->address : old('address') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($veterinaryCenter) ? 'Update' : 'Add' }} Veterinary Center</button>
        </form>
    </div>

    <!-- List of Veterinary Centers -->
    <div class="row">
        @foreach ($veterinaryCenters as $veterinaryCenter)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="cute-card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $veterinaryCenter->name }}</h2>
                        <p class="card-text">Location: {{ $veterinaryCenter->address }}</p>
                        <p class="card-text">Phone Number: {{ $veterinaryCenter->phone_number }}</p>
                        <p class="card-text">City: {{ $veterinaryCenter->city }}</p>
                        <a href="{{ route('admin.veterinary.edit', $veterinaryCenter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.veterinary.delete', $veterinaryCenter->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
