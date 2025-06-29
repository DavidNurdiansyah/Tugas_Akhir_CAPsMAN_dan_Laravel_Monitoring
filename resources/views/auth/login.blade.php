<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Login MikroTik</title>
</head>

<body>
    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
        <h3 class="text-center mb-4 fw-bolder">LOGIN</h3>
        <div class="col-10 col-sm-8 col-md-6 col-lg-4 rounded shadow-lg p-4 p-sm-5" style="background-color: #6C81C6">
            <h3 class="text-white text-center mb-4 fs-4 fw-bold">MONITORING TRAFFIC</h3>
            <form action="{{ route('auth.login') }}" method="POST" class="text-white">
                @csrf
                <!-- IP -->
                <div class="mb-3">
                    <label for="ip" class="form-label">IP</label>
                    <input type="text" class="form-control @error('ip') is-invalid @enderror"
                        value="{{ old('ip') }}" name="ip" aria-describedby="ipHelp">
                    @error('ip')
                        <div id="ipHelp" class="form-text alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username') }}" name="username" aria-describedby="usernameHelp">
                    @error('username')
                        <div id="usernameHelp" class="form-text alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-light text-dark w-75">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
