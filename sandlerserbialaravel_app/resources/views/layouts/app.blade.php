<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Meta Tags -->
        @include('layouts.head.meta') 
        <!-- Title -->
        @include('layouts.head.title')
        <!-- Favicon -->
        @include('layouts.head.favicon')
        <!-- Font Styles (Font Awesome) -->
        @include('layouts.head.style_font')
        <!-- Datepicker Jqery Styles -->
        @include('layouts.head.style_jquery_datepicker')
        <!-- Custom Styles -->
        @include('layouts.head.style')
        <!-- Noscript -->
        @include('layouts.head.noscript')

    </head>
    <body>

        <!-- Navigation Bar -->
        @include('layouts.body.nav') 
        <!-- App Content -->
        @yield('content')
        <!-- Footer -->
        @include('layouts.body.footer')


        <!-- Jquery JS -->
        @include('layouts.body.js.jquery')
        <!-- Bootstrap JS -->
        @include('layouts.body.js.bootstrap')
        <!-- jQuery Validation -->
        @include('layouts.body.js.jquery_validation')
        <!-- Bootstrap Confirmation Custom JS -->
        @include('layouts.body.js.bootstrap_confirmation')
        <!-- Jquery Datepicker JS -->
        @include('layouts.body.js.jquery_datepicker')
        <!-- Custom App JS -->
        @include('layouts.body.js.js')
        <!-- App JS -->
        @yield('script')


    </body>
</html>
