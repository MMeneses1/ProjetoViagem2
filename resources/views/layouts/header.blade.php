<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('titulo') | Pilgrim</title>
        <link href="/css/header.css" rel="stylesheet">
        <link href="@yield('css')" rel="stylesheet">
        <link rel="shortcut icon" href="/images/bussola.png" type="image/icon">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Prompt:wght@300;400&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container-fluid">

            <nav class="navbar header">
                <div class="container">
                <a class="navbar-brand" href="login" wire:navigate>
                    <img src="{{ asset('images/bussola.png') }}" width="25" height="25" alt="Bússola" class="d-inline-block align-text-top">
                    Pilgrim
                </a>
                </div>
            </nav>

            @yield('conteudo')
        
        </div>
    </body>
    </html>