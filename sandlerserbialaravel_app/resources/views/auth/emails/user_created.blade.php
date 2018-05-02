@extends('emails.email_template')

@section('title', 'Obaveštenje')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">

                <div class="panel-heading san-yell">
                    <span class="glyphicon glyphicon-envelope"></span>&nbsp;Serbia Sandler
                  <h3 class="text-center">
                     <i>Obaveštenje</i>
                  </h3>
                </div>

                <div class="panel-body san-yell">
					<br>
					 <div>
					 	<p class="h4 text-primary">Registrovan je novi korisnik: {{ $name }} sa email adresom: {{ $email }}</p>
					</div>
					<br><br>
					<div>
						<h4 class='pull-right'>
						    <i><a class="text-info" href="{{ config('constants.application_url') }}">{{ config('constants.application_name') }}</a></i>
						</h4>
 					</div>

                </div><!-- panel-body  -->

            </div><!-- panel panel-default  -->
        </div>
    </div>
</div>
@endsection 