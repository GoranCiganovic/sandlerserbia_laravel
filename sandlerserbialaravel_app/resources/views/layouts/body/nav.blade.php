<nav class="navbar navbar-default navbar-fixed-top alert-san-grey">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image - Sandler Logo-->
            <a class="navbar-brand" href="{{ url('/') }}">
               <img src="{{asset('/storage/images/sandler/sandler_black_logo_small.png')}}" alt="Sandler Logo">
            </a>

        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/home') }}">
                        <span class="text-primary"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;
                        @if (Auth::guest())
                        	Home
                        @else
                    		Početna
               			@endif
                        </span>
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li>
                        <a href="{{ url('/login') }}">
                            <span class="text-primary"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;Login</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}">
                            <span class="text-primary"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;Register</span>
                        </a>
                    </li>
                @else
                    @include('layouts.body.header')
                @endif
            </ul>
        </div>
    </div>
</nav>