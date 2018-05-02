@extends('layouts.app')

@section('title', 'Porezi')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Porez
                  <!-- Back Button -->
                  <a href="@if(url()->current() != url()->previous()){{ url()->previous()}}@else{{ url('/home')}}@endif 
                  " class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                   <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Porez
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>
        
                <div class="panel-body san-yell">
                  <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("/taxes/update/".$rate->id) }}'>
                    <!-- PDV -->
                    <div class="form-group{{ $errors->has('pdv') ? ' has-error' : '' }}">
                      <label class="control-label" for="pdv">
                        <i class="fa fa-btn fa-percent"></i>PDV (procenat)
                      </label>
                      <input type="text" id="pdv" name="pdv" class="form-control" aria-describedby="pdvHelp" value="{{ $rate->pdv }}" step="0.01">
                      @if ($errors->has('pdv'))
                      <small id="pdvHelp" class="form-text text-danger h5">
                        {{ $errors->first('pdv') }}
                      </small>
                      @endif
                    </div>
                    <!-- /PDV -->
                   	<!-- PDV datum placanja-->
                    <div class="form-group{{ $errors->has('pdv_paying_day') ? ' has-error' : '' }}">
                      <label class="control-label" for="pdv_paying_day">
                        <i class="fa fa-btn fa-calendar"></i>Dan plaćanja PDV-a u mesecu
                      </label>
                      <input type="number" id="pdv_paying_day" name="pdv_paying_day" class="form-control" aria-describedby="pdv_paying_dayHelp" value="{{ $rate->pdv_paying_day }}">
                      @if ($errors->has('pdv'))
                      <small id="pdv_paying_dayHelp" class="form-text text-danger h5">
                        {{ $errors->first('pdv_paying_day') }}
                      </small>
                      @endif
                    </div>
                    <!-- /PDV datum placanja-->
                    <!-- Porez po odbitku-->
                    <div class="form-group{{ $errors->has('ppo') ? ' has-error' : '' }}">
                      <label class="control-label" for="ppo">
                        <i class="fa fa-btn fa-percent"></i>Porez po odbitku (procenat)
                      </label>
                      <input type="text" id="ppo" name="ppo" class="form-control" aria-describedby="ppoHelp" value="{{ $rate->ppo }}" step="0.01">
                      @if ($errors->has('ppo'))
                      <small id="ppoHelp" class="form-text text-danger h5">
                        {{ $errors->first('ppo') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Porez po odbitku-->

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
<script src="/js/rates/taxes.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection
