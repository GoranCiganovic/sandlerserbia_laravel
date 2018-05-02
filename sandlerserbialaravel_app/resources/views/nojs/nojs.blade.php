<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta Tags -->
        @include('layouts.head.meta') 
        <!-- Title -->
       <title>No JavaScript</title>
        <!-- Favicon -->
        @include('layouts.head.favicon')
        <!-- Font Styles (Font Awesome) -->
        @include('layouts.head.style_font')
        <!-- Custom Styles -->
        @include('layouts.head.style')

    </head>
	<body id='noscript'>

        <!-- Navigation Bar -->
        @include('layouts.body.nav') 

        <div class="container main-container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <div class="panel panel-default">

                        <div class="panel-heading san-yell">

                            @if(Auth::check())
                            <a href="{{ url('/logout') }}" class="btn btn-primary pull-right"><i class="fa fa-btn fa-sign-out" aria-hidden="true"></i>{{ $data['logout'] }}</a>
                            @endif

                            <a href="@if(url()->current() != url()->previous()){{ url()->previous()}}@else{{ url('/home')}}@endif" class="btn btn-primary pull-right"><i class="fa fa-btn fa-refresh" aria-hidden="true"></i>{{ $data['reload'] }}</a>
                
                            <i class="fa fa-btn fa-exclamation" aria-hidden="true"></i>{{ $data['information'] }}

                            <h3 class="text-center text-info">{{ $data['message'] }}</h3>

                        </div>

                        <div class="panel-body san-yell">

                            <br>
                             <div>
                                <img id="no_js_img" src="{{ asset($data['img_path']) }}" alt="No Javascript">
                            </div>
                            
                        </div><!-- panel-body  -->

                    </div><!-- panel panel-default  -->
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('layouts.body.footer')
        
        <script>
            /* If JavaScript is Enabled Hide Body(ID=noscript) and Go Back On Second Previous Page */
            document.getElementById('noscript').style.display='none';
            window.history.go(-1);
        </script>
        
	</body>
</html>



