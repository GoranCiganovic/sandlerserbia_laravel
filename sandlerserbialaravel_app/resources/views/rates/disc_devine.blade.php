@extends('layouts.app')

@section('title', 'DISC/Devine')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>DISC/Devine
                  <!-- Back Button -->
                  <a href="@if(url()->current() != url()->previous()){{ url()->previous()}}@else{{ url('/home')}}@endif 
                  " class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>DISC/Devine
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>
        
                <div class="panel-body san-yell">
                  <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("/disc_devine/update/".$rate->id) }}'>
                    <!-- DISC -->
                    <div class="form-group{{ $errors->has('disc') ? ' has-error' : '' }}">
                      <label class="control-label" for="disc">
                        <i class="fa fa-btn fa-dollar"></i>DISC iznos u dolarima
                      </label>
                      <input type="text" id="disc" name="disc" class="form-control" aria-describedby="discHelp" value="{{ $rate->disc }}" step="0.01">
                      @if ($errors->has('disc'))
                      <small id="discHelp" class="form-text text-danger h5">
                        {{ $errors->first('disc') }}
                      </small>
                      @endif
                    </div>
                    <!-- /DISC -->
                    <!-- Devine -->
                    <div class="form-group{{ $errors->has('devine') ? ' has-error' : '' }}">
                      <label class="control-label" for="devine">
                        <i class="fa fa-btn fa-dollar"></i>Devine iznos u dolarima
                      </label>
                      <input type="text" id="devine" name="devine" class="form-control" aria-describedby="devineHelp" value="{{ $rate->devine }}" step="0.01">
                      @if ($errors->has('devine'))
                      <small id="devineHelp" class="form-text text-danger h5">
                        {{ $errors->first('devine') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Devine -->
                   	<!-- Disc/Devine datum placanja-->
                    <div class="form-group{{ $errors->has('dd_paying_day') ? ' has-error' : '' }}">
                      <label class="control-label" for="dd_paying_day">
                        <i class="fa fa-btn fa-calendar"></i>Dan plaćanja u mesecu
                      </label>
                      <input type="number" id="dd_paying_day" name="dd_paying_day" class="form-control" aria-describedby="dd_paying_dayHelp" value="{{ $rate->dd_paying_day }}">
                      @if ($errors->has('dd_paying_day'))
                      <small id="dd_paying_dayHelp" class="form-text text-danger h5">
                        {{ $errors->first('dd_paying_day') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Disc/Devine datum placanja-->
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
<script src="/js/rates/disc_devine.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection