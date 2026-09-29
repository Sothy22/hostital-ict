<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    {{-- Navbar --}}
    <nav>
         <a href="{{ route('home') }}">Home</a>
         <a href="{{ route('about') }}">About Us</a>
         <a href="{{ route('contact') }}">Contact</a>
         <a href="{{ route('contact_us') }}">Contact Us</a>
         <a href="{{ route('department') }}">Department</a>
         <a href="{{ route('doctors') }}">Doctors</a>
     </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
