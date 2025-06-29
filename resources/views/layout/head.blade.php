<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Monitoring Traffic</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    {{-- <link rel="icon" href="{{ asset('template-dashboard') }}/assets/img/icon.ico" type="image/x-icon" /> --}}

    <!-- Fonts and icons -->
    <script src="{{ asset('template-dashboard') }}/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('template-dashboard') }}/assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('template-dashboard') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('template-dashboard') }}/assets/css/atlantis.min.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    {{-- <link rel="stylesheet" href="{{ asset('template-dashboard') }}/assets/css/demo.css"> --}}
    {{-- untuk grafik --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

</head>
