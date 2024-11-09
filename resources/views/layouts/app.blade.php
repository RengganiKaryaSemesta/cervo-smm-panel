<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- {!! $meta !!} --}}
    @stack('styles')
    @vite(['resources/css/app.css'])
</head>

<body class="flex flex-col justify-between min-h-screen pt-20">
    @include('layouts.navbar')
    {{-- {{ $slot }} --}}
    @include('layouts.footer')
</body>

</html>
