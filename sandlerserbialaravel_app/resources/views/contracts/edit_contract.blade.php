@extends('layouts.app')

@section('title', 'Ugovor br.'.$contract->contract_number)

@section('content')
<div class="container main-container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Ugovor
          <!-- Back Button -->
          <a href="{{ url('/contract/'.$contract->id)}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Izmena Ugovora br. {{$contract->contract_number}}
            <h5>              
              @if($client->long_name){{ $client->long_name }} @endif
              @if($client->first_name){{ $client->first_name." ".$client->last_name }} @endif
            </h5>       
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">
         
          <form method="POST" id='form' action='{{ url("/contract/update/".$contract->id) }}' class='form_prevent_multiple_submits'>
            <!-- Vrednost Ugovora-->
            <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
              <label class="control-label" for="value">
                <i class="fa fa-btn fa-eur"></i>Vrednost Ugovora (EUR)
              </label>
              <input type="number" id="value" name="value" class="form-control" aria-describedby="valueHelp" value="{{ $contract->value }}" step="0.01">
              @if ($errors->has('value'))
              <small id="valueHelp" class="form-text text-danger h5">
                {{ $errors->first('value') }}
              </small>
              @endif
            </div>
            <!-- /Vrednost Ugovora -->
            <!-- Vrednost Ugovora slovima -->
            <div class="form-group{{ $errors->has('value_letters') ? ' has-error' : '' }}">
              <label class="control-label" for="value_letters">
                <i class="fa fa-btn fa-pencil"></i>Vrednost Ugovora slovima
              </label>
              <input type="text" id="value_letters" name="value_letters" class="form-control" aria-describedby="value_lettersHelp" value="{{ $contract->value_letters }}">
              @if ($errors->has('value_letters'))
              <small id="value_lettersHelp" class="form-text text-danger h5">
                {{ $errors->first('value_letters') }}
              </small>
              @endif
            </div>
            <!-- /Vrednost Ugovora slovima -->
            <!-- Avans-->
            <div class="form-group{{ $errors->has('advance') ? ' has-error' : '' }}">
              <label class="control-label" for="advance">
                <i class="fa fa-btn fa-eur"></i>Avans (EUR)
              </label>
              <input type="number" id="advance" name="advance" class="form-control" aria-describedby="advanceHelp" value="{{ $contract->advance }}" step="0.01">
              @if ($errors->has('advance'))
              <small id="advanceHelp" class="form-text text-danger h5">
                {{ $errors->first('advance') }}
              </small>
              @endif
            </div>
            <!-- /Avans -->
            <!-- Broj rata -->
            <div class="form-group{{ $errors->has('payments') ? ' has-error' : '' }}">
              <label class="control-label" for="payments">
                <i class="fa fa-btn fa-pencil"></i>Broj rata
              </label>
              <input type="number" id="payments" name="payments" class="form-control" aria-describedby="paymentsHelp" value="{{ $contract->payments }}">
              @if ($errors->has('payments'))
              <small id="paymentsHelp" class="form-text text-danger h5">
                {{ $errors->first('payments') }}
              </small>
              @endif
            </div>
            <!-- /Broj rata -->
            <!-- Broj ucesnika -->
            <div class="form-group{{ $errors->has('participants') ? ' has-error' : '' }}">
              <label class="control-label" for="participants">
                <i class="fa fa-btn fa-pencil"></i>Broj učesnika
              </label>
              <input type="number" id="participants" name="participants" class="form-control" aria-describedby="participantsHelp" value="{{ $contract->participants }}">
              @if ($errors->has('participants'))
              <small id="participantsHelp" class="form-text text-danger h5">
                {{ $errors->first('participants') }}
              </small>
              @endif
            </div>
            <!-- /Broj ucesnika -->
            <!-- Datum Ugovora  -->
            <div class="form-group{{ $errors->has('format_contract_date') ? ' has-error' : '' }}">
              <label class="control-label" for="format_contract_date">
                <i class="fa fa-btn fa-calendar"></i>Datum Ugovora 
              </label>
              <input type="text" id="format_contract_date" name="format_contract_date" class="form-control" aria-describedby="format_contract_dateHelp" value='{{ date("d.m.Y.",strtotime($contract->contract_date)) }}'>
              <input type="hidden" id="contract_date" name="contract_date" value='{{$contract->contract_date}}'>
              @if ($errors->has('format_contract_date'))
              <small id="format_contract_dateHelp" class="form-text text-danger h5">
                {{ $errors->first('format_contract_date') }}
              </small>
              @endif
            </div>
            <!-- /Datum Ugovora  -->
            <!-- Datum pocetka  -->
            <div class="form-group{{ $errors->has('format_start_date') ? ' has-error' : '' }}">
              <label class="control-label" for="format_start_date">
                <i class="fa fa-btn fa-calendar"></i>Datum početka 
              </label>
              <input type="text" id="format_start_date" name="format_start_date" class="form-control" aria-describedby="format_start_dateHelp" value='@if($contract->start_date){{ date("d.m.Y.",strtotime($contract->start_date)) }}@endif'>
              <input type="hidden" id="start_date" name="start_date" value='@if($contract->start_date){{$contract->start_date}}@endif'>
              @if ($errors->has('format_start_date'))
              <small id="format_start_dateHelp" class="form-text text-danger h5">
                {{ $errors->first('format_start_date') }}
              </small>
              @endif
            </div>
            <!-- /Datum pocetka  -->
            <!-- Datum zavrsetka  -->
            <div class="form-group{{ $errors->has('format_end_date') ? ' has-error' : '' }}">
              <label class="control-label" for="format_end_date">
                <i class="fa fa-btn fa-calendar"></i>Datum završetka 
              </label>
              <input type="text" id="format_end_date" name="format_end_date" class="form-control" aria-describedby="format_end_dateHelp" value='@if($contract->end_date){{ date("d.m.Y.",strtotime($contract->end_date)) }}@endif'>
              <input type="hidden" id="end_date" name="end_date" value='@if($contract->end_date){{$contract->end_date}}@endif'>
              @if ($errors->has('format_end_date'))
              <small id="format_end_dateHelp" class="form-text text-danger h5">
                {{ $errors->first('format_end_date') }}
              </small>
              @endif
            </div>
            <!-- /Datum zavrsetka  -->
            <!-- Mesto odrzavanja -->
            <div class="form-group{{ $errors->has('event_place') ? ' has-error' : '' }}">
              <label class="control-label" for="event_place">
                <i class="fa fa-btn fa-map-marker"></i>Mesto održavanja
              </label>
              <input type="text" id="event_place" name="event_place" class="form-control" aria-describedby="event_placeHelp" value="{{ $contract->event_place }}">
              @if ($errors->has('event_place'))
              <small id="event_placeHelp" class="form-text text-danger h5">
                {{ $errors->first('event_place') }}
              </small>
              @endif
            </div>
            <!-- /Mesto odrzavanja -->
            <!-- Broj casova -->
            <div class="form-group{{ $errors->has('classes_number') ? ' has-error' : '' }}">
              <label class="control-label" for="classes_number">
                <i class="fa fa-btn fa-pencil"></i>Broj časova
              </label>
              <input type="text" class="form-control" id="classes_number" name="classes_number" aria-describedby="classes_numberHelp" value="{{ $contract->classes_number }}">
              @if ($errors->has('classes_number'))
              <small id="classes_numberHelp" class="form-text text-danger h5">
                {{ $errors->first('classes_number') }}
              </small>
              @endif
            </div>
            <!-- /Broj casova -->
            <!-- Dinamika rada -->
            <div class="form-group{{ $errors->has('work_dynamics') ? ' has-error' : '' }}">
              <label class="control-label" for="work_dynamics">
                <i class="fa fa-btn fa-pencil"></i>Dinamika rada
              </label>
              <input type="text" class="form-control" id="work_dynamics" name="work_dynamics" aria-describedby="work_dynamicsHelp" value="{{ $contract->work_dynamics }}">
              @if ($errors->has('work_dynamics'))
              <small id="work_dynamicsHelp" class="form-text text-danger h5">
                {{ $errors->first('work_dynamics') }}
              </small>
              @endif
            </div>
            <!-- /Dinamika rada -->
            <!-- Vreme odrzavanja -->
            <div class="form-group{{ $errors->has('event_time') ? ' has-error' : '' }}">
              <label class="control-label" for="event_time">
                <i class="fa fa-btn fa-pencil"></i>Vreme održavanja
              </label>
              <input type="text" id="event_time" name="event_time" class="form-control" aria-describedby="event_timeHelp" value="{{ $contract->event_time }}">
              @if ($errors->has('event_time'))
              <small id="event_timeHelp" class="form-text text-danger h5">
                {{ $errors->first('event_time') }}
              </small>
              @endif
            </div>
            <!-- /Vreme odrzavanja -->
            <!-- Opis Ugovora -->
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
              <label class="control-label" for="description">
                <i class="fa fa-btn fa-comment"></i>Opis Ugovora
              </label>
              <textarea id="description" name="description"  class="form-control" aria-describedby="descriptionHelp" rows="5">{{ $contract->description }}</textarea>
              @if ($errors->has('description'))
              <small id="descriptionHelp" class="form-text text-danger h5">
                {{ $errors->first('description') }}
              </small>
              @endif
            </div>
            <!-- /Opis Ugovora -->

            <!-- /Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- /Token -->
            <!-- Button -->
            <div class="panel panel-default san-light">
              <button type="submit" id="submit" name="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                  <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>POTVRDI IZMENU
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
<script src="/js/contracts/create.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection
