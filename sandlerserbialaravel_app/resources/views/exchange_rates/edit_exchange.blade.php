@extends('layouts.app')

@section('title', 'Kurs')

@section('content')
<div class="container main-container"> 
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-edit" aria-hidden="true"></i>Kurs
                  <!-- Back Button -->
                  <a href="{{ url('/exchange')}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Kursna lista</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                      @if($exchange->currency == 'EUR')<span class="eu-lg-flag glyphicon glyphicon-globe"></span>@endif
                      @if($exchange->currency == 'USD')<span class="usa-lg-flag glyphicon glyphicon-globe"></span>@endif
                      {{$exchange->currency}}
                  </div>
                  <!-- /Title -->
                  <!--Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>
        
                <div class="panel-body san-yell">
                  <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("/exchange/update/".$exchange->id) }}'>
                    <!-- Valuta -->
                    <div class="form-group">
                      <label class="control-label">
                        @if($exchange->currency == 'EUR')<i class="fa fa-btn fa-eur"></i>@endif
                        @if($exchange->currency == 'USD')<i class="fa fa-btn fa-dollar"></i>@endif
                        Valuta
                      </label>
                      <div class="form-control">{{ $exchange->currency }}</div>
                    </div>
                    <!-- /Valuta -->
                    <!-- Srednji kurs (RSD) -->
                    <div class="form-group{{ $errors->has('exchange_value') ? ' has-error' : '' }}">
                      <label class="control-label" for="exchange_value">
                        <i class="fa fa-btn fa-pencil"></i>Srednji kurs (RSD)
                      </label>
                      <input type="number" id="exchange_value" name="exchange_value" class="form-control" aria-describedby="exchange_valueHelp" value="{{ $exchange->value }}" step="0.0001">
                      @if ($errors->has('exchange_value'))
                      <small id="exchange_valueHelp" class="form-text text-danger h5">
                        {{ $errors->first('exchange_value') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Srednji kurs (RSD) -->
                   	<!-- Kurs izmenjen dana -->
                    <div class="form-group">
                      <label class="control-label">
                        <i class="fa fa-btn fa-calendar"></i>Kurs izmenjen dana
                      </label>
                      <div class="form-control">@if($exchange->updated_at){{ date("d.m.Y.",strtotime($exchange->updated_at)) }} u {{ date("H:i:s",strtotime($exchange->updated_at)) }}@endif</div>
                    </div>
                    <!-- /Kurs izmenjen dana-->
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

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/js/exchange_rates/exchange.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection