<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Valins System' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Pastikan baris ini ada dan memanggil app.css DAN app.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal p-4 md:p-8">

    <!-- Ini adalah Slot, tempat konten dari halaman lain akan disuntikkan -->
    {{ $slot }}
</body>
</html>
