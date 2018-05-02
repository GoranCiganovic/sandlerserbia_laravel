<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Meta Tags -->
        @include('layouts.head.meta') 
        <!-- Title -->
        <title>Ugovor</title>
        <!-- Bootstrap CDN Styles -->
        @include('layouts.head.style_bootstrap') 
        <!-- Styles Custom -->
		<style type="text/css">

            body, html {
                height: 100%;
                font-size:16px;
            }
            /* Contract Background */
            .bg { 
            	position: fixed;
            	width:100%;
            	height:100%;
                background-image: url("{{ asset('/storage/images/sandler/sandler_logo.gif')}}");
              	height:5000px;
              	opacity: 0.1;
                background-position: left top;
                background-repeat: repeat;
            }
            /* Contract Signature Line */
			.signature{
				 border-bottom: 1px solid #000;
				 height: 80px;
			}	

		</style>

    </head>
	<body>

		@if($logo_bg)		
		<div class="bg"></div>
		@endif

        <div class='container'>
		{!! $contract !!}
        </div>

        
	</body>
</html>
