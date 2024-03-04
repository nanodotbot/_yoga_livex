<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link rel="stylesheet" href="{{ asset('main.css') }}">
        <link rel="stylesheet" href="{{ asset('single.css') }}">
        <link rel="stylesheet" href="{{ asset('header.css') }}">
        <link rel="stylesheet" href="{{ asset('footer.css') }}">
        <link rel="stylesheet" href="{{ asset('flash-message.css') }}">
    </head>
    
    <body class="antialiased">

        <main class="errors">

            <h1>
                @yield('code')
            </h1>
            <h2>
                @yield('message')
            </h2>
            <p>This is not supposed to happen. You're welcome to report the issue via the <a href="/contact">contact form</a> or to return to the <a href="/">home page</a>.</p>

        </main>

    </body>

</html>