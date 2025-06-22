<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', '')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            html, body {
                height: 100%;
            }
            body {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                margin: 0;
                font-family: 'Figtree', Arial, sans-serif;
                background: #fff;
                color: #1a1a1a;
            }
            header {
                background: #d52b1e;
                color: #fff;
                padding: 1.5rem 0;
                text-align: center;
                font-size: 2rem;
                font-weight: bold;
                letter-spacing: 2px;
                border-bottom: 6px solid #0039a6;
            }
            main {
                flex: 1 0 auto;
                max-width: 1600px;
                margin: 2rem auto;
                background: #f5f5f5;
                border: 1px solid #0039a6;
                border-radius: 8px;
                padding: 2rem;
                min-height: 60vh;
            }
            footer {
                flex-shrink: 0;
                background: #0039a6;
                color: #fff;
                text-align: center;
                padding: 1rem 0;
                font-size: 1rem;
                margin-top: 2rem;
            }
            h1, h2, h3, h4, h5, h6 {
                color: #0039a6;
                margin-top: 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 1.5rem 0;
            }
            th, td {
                border: 1px solid #0039a6;
                padding: 0.75rem 1rem;
                text-align: left;
            }
            th {
                background: #d52b1e;
                color: #fff;
            }
            tr:nth-child(even) {
                background: #e6e6e6;
            }
            tr:hover {
                background: #f2dede;
            }
            @media (max-width: 600px) {
                main {
                    padding: 1rem;
                }
                table, th, td {
                    font-size: 0.95rem;
                }
            }
        </style>
        @yield('head')
    </head>
    <body>
        <header>
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
            &copy; {{ date('Y') }}
        </footer>
    </body>
</html>
