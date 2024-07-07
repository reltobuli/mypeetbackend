@extends('layouts.app')

@section('title', 'Veterinary Management')

@section('content')
<div class="container">
    <header>
        <h1>Manage Veterinary Centers</h1>
    </header>

    <!-- Add/Edit Veterinary Center Form -->
    <div class="form-container">
        <form action="{{ isset($veterinaryCenter) ? route('admin.veterinary.update', $veterinaryCenter->id) : route('admin.veterinary.store') }}" method="POST">
            @csrf
            @if(isset($veterinaryCenter))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->name : old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone:</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->phone_number : old('phone_number') }}" required>
            </div>
            <div class="form-group">
                <label for="rating">Rating:</label>
                <input type="integer" id="rating" name="rating" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->rating : old('rating') }}" required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->city : old('city') }}" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="{{ isset($veterinaryCenter) ? $veterinaryCenter->address : old('address') }}" required>
            </div>
            <button type="submit" class="button">{{ isset($veterinaryCenter) ? 'Update' : 'Add' }} Veterinary Center</button>
        </form>
    </div>

    <!-- List of Veterinary Centers -->
    @foreach ($veterinaryCenters as $veterinaryCenter)
        <div class="card">
            <h2>{{ $veterinaryCenter->name }}</h2>
            <p>Location: {{ $veterinaryCenter->address }}</p>
            <p>Phone Number: {{ $veterinaryCenter->phone_number }}</p>
            <p>City: {{ $veterinaryCenter->city }}</p>
            <a href="{{ route('admin.veterinary.edit', $veterinaryCenter->id) }}" class="button">Edit</a>
            <form action="{{ route('admin.veterinary.delete', $veterinaryCenter->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="button">Delete</button>
            </form>
        </div>
    @endforeach
</div>
@endsection