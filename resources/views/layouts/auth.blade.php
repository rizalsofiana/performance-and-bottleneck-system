<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Masuk') — SmartHRIS</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

  @vite(['resources/css/app.css'])

  @stack('styles')
</head>

<body class="auth-shell min-h-screen bg-slate-50 text-slate-800 antialiased">
  <div class="flex min-h-screen flex-col items-center justify-center px-4 py-10">
    @yield('content')
  </div>
</body>
</html>
