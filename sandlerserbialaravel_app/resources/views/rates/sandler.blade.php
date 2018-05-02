@extends('layouts.app')

@section('title', 'Sandler')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Sandler
                  <!-- Back Button -->
                  <a href="@if(url()->current() != url()->previous()){{ url()->previous()}}@else{{ url('/home')}}@endif 
                  " class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Sandler procenat
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- Message -->
                </div>
        
                <div class="panel-body san-yell">
                  <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("/sandler/update/".$rate->id) }}'>
                    <!-- Sandler -->
                    <div class="form-group{{ $errors->has('sandler') ? ' has-error' : '' }}">
                      <label class="control-label" for="sandler">
                        <i class="fa fa-btn fa-percent"></i>Sandler (procenat)
                      </label>
                      <input type="text" id="sandler" name="sandler" class="form-control" aria-describedby="sandlerlHelp" value="{{ $rate->sandler }}" step="0.01">
                      @if ($errors->has('sandler'))
                      <small id="sandlerlHelp" class="form-text text-danger h5">
                        {{ $errors->first('sandler') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Sandler -->
                   	<!-- Sandler datum placanja-->
                    <div class="form-group{{ $errors->has('sandler_paying_day') ? ' has-error' : '' }}">
                      <label class="control-label" for="sandler_paying_day">
                        <i class="fa fa-btn fa-calendar"></i>Dan plaćanja u mesecu
                      </label>
                      <input type="number" id="sandler_paying_day" name="sandler_paying_day" class="form-control" aria-describedby="sandler_paying_daylHelp" value="{{ $rate->sandler_paying_day }}">
                      @if ($errors->has('sandler_paying_day'))
                      <small id="sandler_paying_daylHelp" class="form-text text-danger h5">
                        {{ $errors->first('sandler_paying_day') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Sandler datum placanja-->
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
<script src="/js/rates/sandler.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection
