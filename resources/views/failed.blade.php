<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Connection Failed!</title>

    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,900" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="{{ asset('error') }}/css/style.css" />

</head>

<body>

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>UPS!</h1>
            </div>
            <h2>Connection error: Authentication failed.</h2>
            <p>Please check your login credentials.</p>
            <a href="{{ route('auth.index') }}">Back To Login</a>
        </div>
    </div>

</body>

</html>
