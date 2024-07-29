<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="app">
       
        <main class="main-content">
            @yield('content')
        </main>
    </div>
    <div class="container" id="profile-section" style="display: none;">
        <h1>Profile Settings</h1>
        <form id="profile-form" method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="email">Email:</label>
                @if (auth()->check())
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
                @else
                    <input type="email" id="email" name="email" value="" required>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="button">Save</button>
        </form>
    </div>

    <script>
        document.getElementById('profile-link').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('profile-section').style.display = 'block';
        });
    </script>
</body>
</html>