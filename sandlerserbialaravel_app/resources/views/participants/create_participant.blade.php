@extends('layouts.app')

@section('title', 'Novi učesnik')
    
@section('content')
<div class="container main-container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-edit" aria-hidden="true"></i>Učesnik
          <!-- Back Button -->
          <a href="{{ url('/participants/'.$contract->id)}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Učesnici</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-user" aria-hidden="true"></i>Novi učesnik 
            <h5>Ugovora br. {{ $contract->contract_number}} od {{ date("d.m.Y.",strtotime($contract->contract_date)) }}</h5>
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
          <!-- Error - Double  Click -->
          @if ($errors->has('single_submit'))
            <div class="text-info h4 text-center"><i>{{ $errors->first('single_submit') }}</i></div>
          @endif
          <!-- /Error - Double  Click -->
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">
         
          <form method="POST" id='form' action='{{ url("/participant/store/".$contract->id) }}' class='form_prevent_multiple_submits'>
            <!-- Ime i prezime -->
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label class="control-label" for="name">
                <i class="fa fa-btn fa-user"></i>Ime i prezime 
              </label>
              <input type="text" id="name" name="name" class="form-control" aria-describedby="nameHelp" placeholder="Unesi ime i prezime" value="{{ old('name') }}">
              @if ($errors->has('name'))
              <small id="nameHelp" class="form-text text-danger h5">
                {{ $errors->first('name') }}
              </small>
              @endif
            </div>
            <!-- /Ime i prezime  -->
            <!-- Pozicija -->
            <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
              <label class="control-label" for="position">
                <i class="fa fa-btn fa-pencil"></i>Pozicija
              </label>
              <input type="text" id="position" name="position" class="form-control" aria-describedby="positionHelp" placeholder="Unesi poziciju" value="{{ old('position') }}">
              @if ($errors->has('position'))
              <small id="positionHelp" class="form-text text-danger h5">
                {{ $errors->first('position') }}
              </small>
              @endif
            </div>
            <!-- /Pozicija -->
            <!-- Email -->
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label class="control-label" for="email">
                <i class="fa fa-btn fa-at"></i>Email adresa
              </label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Unesi email adresu" value="{{ old('email') }}">
              @if ($errors->has('email'))
              <small id="emailHelp" class="form-text text-danger h5">
                {{ $errors->first('email') }}
              </small>
              @endif
            </div>
            <!-- /Email -->
           <!-- Telefon -->
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
              <label class="control-label" for="phone">
                <i class="fa fa-btn fa-phone"></i>Telefon
              </label>
              <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" placeholder="Unesi broj telefona" value="{{ old('phone') }}">
              @if ($errors->has('phone'))
              <small id="phoneHelp" class="form-text text-danger h5">
                {{ $errors->first('phone') }}
              </small>
              @endif
            </div>
            <!-- /Telefon -->

            <!-- Current Time For Single Submit -->
            <input type="hidden" name="single_submit" value="{{ $current_time }}">
            <!-- /Current Time For Single Submit -->
            <!-- /Token -->
            <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
            <!-- /Token -->
            <!-- Button -->
            <div class="panel panel-default san-light">
              <button type="submit" id="submit" name="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                  <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>POTVRDI 
              </button>
            </div>
            <!--/Button -->
          </form>
      
        </div><!--/panel-body -->

      </div><!-- panel panel-default -->

    </div>
  </div>
</div>
<div class="container"></div>
@endsection

@section('script')
<script src="/js/participants/create_participant.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection