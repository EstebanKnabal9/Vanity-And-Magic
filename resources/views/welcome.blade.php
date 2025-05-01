<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Asegúrate de tener Tailwind u otro CSS --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        a {
            text-decoration: none;
            background-color: #3b82f6;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido al Sistema de Inventario Vanity and Magic</h1>
        <p>Gestiona tu tienda y más desde tu panel de administración.</p>
        <a href="{{ route('panel.inicio') }}">Ir al Panel</a>
    </div>
</body>
</html>
