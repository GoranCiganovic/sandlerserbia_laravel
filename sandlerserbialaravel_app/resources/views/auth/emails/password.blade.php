@extends('emails.email_template')

@section('title', 'Zaboravljena lozinka')

@section('content')
<div class="container main-container">
	<div class="well san-blue text-center">
		<h3>
		    <span class="text-info">Zaboravljena lozinka - {{ config('constants.application_name') }}</span>
		</h3>
		<p class="text-white"><span>Za resetovanje lozinke klikni ovde:</span><br>
		    <a class="text-warning" href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
		</p>
		<h4>
		    <i><a class="text-info" href="{{ config('constants.application_url') }}">{{ config('constants.application_name') }}</a></i>
		</h4>
	</div>
</div>
@endsection

 
