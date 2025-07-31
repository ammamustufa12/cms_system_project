<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ twillTitle() }}</title>
    @twillCss
</head>
<body class="twill-login">
    <div id="app">
        <main class="container">
            @yield('content')
        </main>
    </div>

    @twillJs
</body>
</html>
