<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP System</title>
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">

    <div class="min-h-screen flex items-center justify-center">
        {{ $slot }}
    </div>

    @livewireScripts
    <script src="https://cdn.tailwindcss.com"></script>

</body>
</html>
