@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Admin Dashboard</h1>
            <div class="card">
                <div class="card-body">
                    <h3>Manage Instruction List for Street Animals</h3>
                    <a href="{{ route('admin.instructions.index') }}" class="btn btn-primary">Manage Instructions</a>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h3>Manage Veterinary Centers</h3>
                    <a href="{{ route('admin.veterinary') }}" class="btn btn-primary">Manage Veterinary Centers</a>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h3>Manage Shelters </h3>
                    <a href="{{ route('admin.shelters') }}" class="btn btn-primary">Manage Shelters </a>
                </div>
            </div>
            <div class="card mt-3">
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
</div>
@endsection