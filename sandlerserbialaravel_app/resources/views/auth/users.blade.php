@extends('layouts.app')

@section('title', 'Korisnici')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-users" aria-hidden="true"></i>Korisnici
                  <!-- Back Button -->
                  <a href="{{ url('/home')}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Message -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-users" aria-hidden="true"></i>Korisnici
                  </div>
                  <!-- /Message -->
                  <!-- Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>
        
                <div class="panel-body san-yell">
                  @foreach($users as $user)
                    <a href='{{ url("/user/show/".$user->id) }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
                      <i class="fa fa-btn fa-user" aria-hidden="true"></i>
                      {{ $user->name}}
                      @if($user->is_unauthorized == '1')
                      <span class='text-warning'>&nbsp;Zabranjen pristup</span>
                      @endif
                    </a>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container"></div>
@endsection

