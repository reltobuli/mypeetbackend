@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="container">
    <h1>Profile Settings</h1>
    
    <!-- Display success message if set -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
        </div>
        
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password">
        </div>
        
        <div class="form-group">
            <label for="password_confirmation">Confirm New Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
        
        <button type="submit" class="button">Save</button>
    </form>
</div>
@endsection
