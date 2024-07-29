@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>PawPrint</h4>
        </div>
        <div class="sidebar-content">
            <nav>
            <a href="{{ route('admin.index') }}" class="nav-link">Home</a>
                <a href="#" class="nav-link">Notifications</a>
                <a href="{{ route('admin.profile') }}" class="nav-link">Profile</a>
     
               <a href="#" class="nav-link">Settings</a>
            </nav>
        </div>
    </div>
    <div class="main-content">
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="content">
        <!-- Card elements here -->
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h3>Manage Instruction List </h3>
                    <a href="{{ route('admin.instructions.index') }}" class="btn">Manage Instructions</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Manage Veterinary Centers</h3>
                    <a href="{{ route('admin.veterinary') }}" class="btn">Manage Veterinary Centers</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Manage Shelters</h3>
                    <a href="{{ route('admin.shelters') }}" class="btn">Manage Shelters</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Missing Pets Report</h3>
                    <p>30 missing dogs</p>
                    <p>40 missing cats</p>
                    <p>26 rescued dogs</p>
                    <p>33 rescued cats</p>
                </div>
           
        </div>
    </div>
</div>
@endsection