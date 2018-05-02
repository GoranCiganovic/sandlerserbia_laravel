@extends('layouts.app')

@section('title', 'Korisnik')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-user" aria-hidden="true"></i>Korisnik
                  <!-- Back Button -->
                  <a href="{{ url('/users')}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Korisnici</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-user" aria-hidden="true"></i><span id='user'>{{ $user->name }}</span>
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>
        
                <div class="panel-body san-yell">
                    <!-- Pravo pristupa -->
                    <div class="form-group">
                      <label class="control-label" for="name">
                        <i class="fa fa-btn 
                         @if($user->is_unauthorized == '1') fa-lock @else fa-unlock @endif" aria-hidden="true"></i>Pravo pristupa
                      </label>
                      <div class="form-control">
                      @if($user->is_unauthorized == '1')
                        Onemogućen pristup
                      @else
                        Omogućen pristup
                      @endif
                      </div>
                    </div>
                    <!-- /Pravo pristupa  -->
                    <!-- Ime -->
                    <div class="form-group">
                      <label class="control-label" for="name">
                        <i class="fa fa-btn fa-user"></i>Ime
                      </label>
                      <div class="form-control">{{ $user->name }}</div>
                    </div>
                    <!-- /Ime -->
                    <!-- Email -->
                    <div class="form-group">
                      <label class="control-label" for="email">
                        <i class="fa fa-btn fa-at"></i>Email adresa
                      </label>
                      <div class="form-control">{{ $user->email }}</div>
                    </div>
                    <!-- /Email -->
                    <!-- Telefon -->
                    <div class="form-group">
                      <label class="control-label" for="phone">
                        <i class="fa fa-btn fa-phone"></i>Telefon
                      </label>
                      <div class="form-control">@if($user->phone){{ $user->phone }}@endif</div>
                    </div>
                    <!-- /Telefon -->
                    <!-- Registrovan  -->
                    <div class="form-group">
                      <label class="control-label" for="phone">
                        <i class="fa fa-btn fa-calendar"></i>Registrovan 
                      </label>
                      <div class="form-control">
                      @if($user->created_at)
                        {{ date("d.m.Y. h:m:s",strtotime($user->created_at)) }}
                      @endif
                      </div>
                    </div>
                    <!-- /Registrovan  -->
                    <!-- Izmenjen  -->
                    <div class="form-group">
                      <label class="control-label" for="phone">
                        <i class="fa fa-btn fa-calendar"></i>Izmenjen 
                      </label>
                      <div class="form-control">
                      @if($user->updated_at)
                        {{ date("d.m.Y. h:m:s",strtotime($user->updated_at)) }}
                      @endif
                      </div>
                    </div>
                    <!-- /Izmenjen  -->
                    @if($user->is_unauthorized == '1')
                    <!-- OMOGUĆI PRISTUP -->
                    <div class="panel panel-default san-light">
                      <a href='{{ url("/user/authorized/".$user->id) }}' id="authorized_user" class='btn btn-primary btn-block' role='button'>
                          <i class="no_spinner fa fa-btn fa-unlock" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>
                          <span>OMOGUĆI PRISTUP</span>
                      </a>
                    </div>
                    <!-- /OMOGUĆI PRISTUP -->
                    @endif
                    @if($user->is_unauthorized == '0')
                    <!-- ONEMOGUĆI PRISTUP -->
                    <div class="panel panel-default san-light">
                      <a href='{{ url("/user/unauthorized/".$user->id) }}' id="unauthorized_user" class='btn btn-primary btn-block' role='button'>
                          <i class="no_spinner fa fa-btn fa-lock" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>
                          <span>ONEMOGUĆI PRISTUP</span>
                      </a>
                    </div>
                    <!-- /ONEMOGUĆI PRISTUP -->
                    @endif
                    <!-- OBRIŠI KORISNIKA -->
                    <div class="panel panel-default san-light">
                      <a href='{{ url("/user/delete/".$user->id) }}' id="delete_user" class='btn btn-danger btn-block' role='button'>
                          <i class="no_spinner fa fa-btn fa-times" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>
                          <span>OBRIŠI KORISNIKA</span>
                      </a>
                    </div>
                    <!-- /OBRIŠI UGOVOR -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container"></div>
@endsection

@section('script')
<script src="/js/users/confirm_user.js"></script>
@endsection

