@extends('layouts.app')

@section('title', 'Edit Shelter')

@section('content')
<div class="container">
    <h1>Edit Shelter</h1>
    <form action="{{ route('admin.shelters.update', $shelter->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $shelter->name }}" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="{{ $shelter->location }}" required>
        </div>
        <div class="form-group">
            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" value="{{ $shelter->capacity }}" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="{{ $shelter->address }}" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ $shelter->phone_number }}" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="{{ $shelter->city }}" required>
        </div>
        <button type="submit" class="button">Update Shelter</button>
    </form>
</div>
@endsection