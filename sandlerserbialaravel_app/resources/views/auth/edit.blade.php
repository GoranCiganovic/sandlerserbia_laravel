@extends('layouts.app')

@section('title', 'Moj profil')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Profil
                  <!-- Back Button -->
                  <a href="@if(url()->current() != url()->previous()){{ url()->previous()}}@else{{ url('/home')}}@endif 
                  " class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-user" aria-hidden="true"></i>{{ $user->name }}
                    @if($user->is_admin == '1') - Administrator @endif
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>
        
                <div class="panel-body san-yell">
                  <form method="POST" id='form' class='form_prevent_multiple_submits' action="/user/update/{{ $user->id }}">
                    <!-- Ime -->
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label class="control-label" for="name">
                        <i class="fa fa-btn fa-user"></i>Ime
                      </label>
                      <input type="text" id="name" name="name" class="form-control" aria-describedby="nameHelp" value="{{ $user->name }}">
                      @if ($errors->has('name'))
                      <small id="nameHelp" class="form-text text-danger h5">
                        {{ $errors->first('name') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Ime -->
                    <!-- Email -->
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label class="control-label" for="email">
                        <i class="fa fa-btn fa-at"></i>Email adresa
                      </label>
                      <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ $user->email }}">
                      @if ($errors->has('email'))
                      <small id="emailHelp" class="form-text text-danger h5">
                        {{ $errors->first('email') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Email -->
                    <!-- Lozinka -->
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <label class="control-label" for="password">
                        <i class="fa fa-btn fa-lock"></i>Lozinka
                      </label>
                      <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelp" placeholder="Unesi lozinku" value="{{ old('password') }}">
                      @if ($errors->has('password'))
                      <small id="passwordHelp" class="form-text text-danger h5">
                        {{ $errors->first('password') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Lozinka -->
                    <!-- Potvrda lozinke -->
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                      <label class="control-label" for="password">
                        <i class="fa fa-btn fa-lock"></i>Potvrda lozinke
                      </label>
                      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" aria-describedby="password_confirmationHelp" placeholder="Potvrdi lozinku" value="{{ old('password_confirmation') }}">
                      @if ($errors->has('password_confirmation'))
                      <small id="password_confirmationHelp" class="form-text text-danger h5">
                        {{ $errors->first('password_confirmation') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Potvrda lozinke -->
                    <!-- Telefon -->
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                      <label class="control-label" for="phone">
                        <i class="fa fa-btn fa-phone"></i>Telefon
                      </label>
                      <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" value="{{ $user->phone }}">
                      @if ($errors->has('phone'))
                      <small id="phoneHelp" class="form-text text-danger h5">
                        {{ $errors->first('phone') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Telefon -->
                    <!-- /Token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- /Token -->
                    <!-- Button -->
                    <div class="panel panel-default san-light">
                      <button type="submit" id="user_profile_submit" name="user_profile_submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                          <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>POTVRDI IZMENU
                      </button>
                    </div>
                    <!--/Button -->
                  </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container"></div>
@endsection

@section('script')
<script src="/js/users/edit_profile.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection

