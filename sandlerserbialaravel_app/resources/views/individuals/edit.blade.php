@extends('layouts.app')

@section('title', $client_status->global_name.' profil' )

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>
                   Profil - {{ $client_status->global_name }}
                  <!-- Back Button -->
                  <a href="{{ url('/client/'.$clientID)}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Profil</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Izmena profila<br>
                    <h5>{{ $individual->first_name." ".$individual->last_name }}</h5>
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                  <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>
 
                <div class="panel-body san-yell">
                  <form method="POST" id='form' action='{{ url("/individual/update/".$individual->id) }}' class='form_prevent_multiple_submits'>
                    <!-- Ime-->
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                      <label class="control-label" for="first_name">
                        <i class="fa fa-btn fa-user"></i>Ime
                      </label>
                      <input type="text" id="first_name" name="first_name" class="form-control" aria-describedby="first_nameHelp" value="{{ $individual->first_name }}">
                      @if ($errors->has('first_name'))
                      <small id="first_nameHelp" class="form-text text-danger h5">
                        {{ $errors->first('first_name') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Ime -->
                    <!-- Prezime-->
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                      <label class="control-label" for="last_name">
                        <i class="fa fa-btn fa-user"></i>Prezime
                      </label>
                      <input type="text" id="last_name" name="last_name" class="form-control" aria-describedby="last_nameHelp" value="{{ $individual->last_name }}">
                      @if ($errors->has('last_name'))
                      <small id="last_nameHelp" class="form-text text-danger h5">
                        {{ $errors->first('last_name') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Prezime -->
                    <!-- Komentar -->
                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                      <label class="control-label" for="comment">
                        <i class="fa fa-btn fa-comment"></i>Komentar
                      </label>
                      <textarea id="comment" name="comment"  class="form-control" aria-describedby="commentHelp" rows="5">{{ $individual->comment }}</textarea>
                      @if ($errors->has('comment'))
                      <small id="commentHelp" class="form-text text-danger h5">
                        {{ $errors->first('comment') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Komentar -->
                    <!-- Telefon -->
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                      <label class="control-label" for="phone">
                        <i class="fa fa-btn fa-phone"></i>Telefon
                      </label>
                      <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" value="{{ $individual->phone }}">
                      @if ($errors->has('phone'))
                      <small id="phoneHelp" class="form-text text-danger h5">
                        {{ $errors->first('phone') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Telefon -->
                    <!-- Email -->
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label class="control-label" for="email">
                        <i class="fa fa-btn fa-at"></i>Email adresa
                      </label>
                      <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ $individual->email }}">
                      @if ($errors->has('email'))
                      <small id="emailHelp" class="form-text text-danger h5">
                        {{ $errors->first('email') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Email -->
                    <!-- JMBG-->
                    <div class="form-group{{ $errors->has('jmbg') ? ' has-error' : '' }}">
                      <label class="control-label" for="jmbg">
                        <i class="fa fa-btn fa-pencil"></i>JMBG
                      </label>
                      <input type="number" id="jmbg" name="jmbg" class="form-control" aria-describedby="jmbgHelp" value="{{ $individual->jmbg }}">
                      @if ($errors->has('jmbg'))
                      <small id="jmbgHelp" class="form-text text-danger h5">
                        {{ $errors->first('jmbg') }}
                      </small>
                      @endif
                    </div>
                    <!-- /JMBG -->
                    <!-- Broj lične karte -->
                    <div class="form-group{{ $errors->has('id_card') ? ' has-error' : '' }}">
                      <label class="control-label" for="id_card">
                        <i class="fa fa-btn fa-pencil"></i>Broj lične karte
                      </label>
                      <input type="number" id="id_card" name="id_card" class="form-control" aria-describedby="id_cardHelp" value="{{ $individual->id_card }}">
                      @if ($errors->has('id_card'))
                      <small id="id_cardHelp" class="form-text text-danger h5">
                        {{ $errors->first('id_card') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Broj lične karte -->
                    <!-- Zaposlen u -->
                    <div class="form-group{{ $errors->has('works_at') ? ' has-error' : '' }}">
                      <label class="control-label" for="works_at">
                        <i class="fa fa-btn fa-building"></i>Zaposlen u
                      </label>
                      <input type="text" id="works_at" name="works_at" class="form-control" aria-describedby="works_atHelp" value="{{ $individual->works_at }}">
                      @if ($errors->has('works_at'))
                      <small id="works_atHelp" class="form-text text-danger h5">
                        {{ $errors->first('works_at') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Zaposlen u -->
                    <!-- Adresa -->
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                      <label class="control-label" for="address">
                        <i class="fa fa-btn fa-map-marker"></i>Adresa
                      </label>
                      <input type="text" id="address" name="address" class="form-control" aria-describedby="addressHelp" value="{{ $individual->address }}">
                      @if ($errors->has('address'))
                      <small id="addressHelp" class="form-text text-danger h5">
                        {{ $errors->first('address') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Adresa -->
                    <!-- Opština -->
                    <div class="form-group{{ $errors->has('county') ? ' has-error' : '' }}">
                      <label class="control-label" for="county">
                        <i class="fa fa-btn fa-map-marker"></i>Opština
                      </label>
                      <input type="text" id="county" name="county" class="form-control" aria-describedby="countyHelp" value="{{ $individual->county }}">
                      @if ($errors->has('county'))
                      <small id="countyHelp" class="form-text text-danger h5">
                        {{ $errors->first('county') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Opština -->
                    <!-- Poštanski broj -->
                    <div class="form-group{{ $errors->has('postal') ? ' has-error' : '' }}">
                      <label class="control-label" for="postal">
                        <i class="fa fa-btn fa-pencil"></i>Poštanski broj
                      </label>
                      <input type="number" id="postal" name="postal" class="form-control" aria-describedby="postalHelp" value="{{ $individual->postal }}">
                      @if ($errors->has('postal'))
                      <small id="postalHelp" class="form-text text-danger h5">
                        {{ $errors->first('postal') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Poštanski broj -->
                    <!-- Grad -->
                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                      <label class="control-label" for="city">
                        <i class="fa fa-btn fa-map-marker"></i>Grad
                      </label>
                      <input type="text" id="city" name="city" class="form-control" aria-describedby="cityHelp" value="{{ $individual->city }}">
                      @if ($errors->has('city'))
                      <small id="cityHelp" class="form-text text-danger h5">
                        {{ $errors->first('city') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Grad -->
                    <!-- /Token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- /Token -->
                    <!-- Button -->
                    <div class="panel panel-default san-light">
                      <button type="submit" id="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                          <i class="no_spinner fa fa-btn fa-check"></i><i class='spinner fa fa-btn fa-spinner fa-spin'></i>POTVRDI 
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
<script src="/js/individuals/individual.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection