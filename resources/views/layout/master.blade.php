<!DOCTYPE html>
<html lang="en">

@include('layout.head')


<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            @include('layout.header')
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            @include('layout.navbar')
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        @include('layout.sidebar')
        <!-- End Sidebar -->

        @yield('content')
    </div>

    @include('layout.script')

</body>

</html>
