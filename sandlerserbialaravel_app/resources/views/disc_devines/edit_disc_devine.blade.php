@extends('layouts.app')

@section('title', 'DISC/Devine dug')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <span class="disc-devine-icon glyphicon glyphicon-globe"></span>&nbsp;&nbsp;DISC/Devine
                  <!-- Back Button -->
                  <a href="{{ url('/disc_devine/debt')}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <span class="disc-devine-icon-lg glyphicon glyphicon-globe"></span>&nbsp;&nbsp;DISC/Devine test  {{ $participant->name }} 
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                  <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>

                <div class="panel-body san-yell">
                  <div class="row">

                    <div class="col-xs-12">

                      <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("/disc_devine/update_debt/".$disc_devine->id) }}'>
                        <!-- DISC -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-dollar"></i>DISC (USD)
                          </label>
                          <div class='form-control'>
                            {{ number_format($disc_devine->disc_dollar, 2, ',', '.') }}&nbsp;$
                          </div>
                        </div>
                        <!-- /DISC -->
                        <!-- Devine -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-dollar"></i>Devine (USD)
                          </label>
                          <div class='form-control'>
                            {{ number_format($disc_devine->devine_dollar, 2, ',', '.') }}&nbsp;$
                          </div>
                        </div>
                        <!-- /Devine -->
                        <!-- DISC/Devine -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-dollar"></i>DISC/Devine (USD)
                          </label>
                          <div class='form-control'>
                            {{ number_format($disc_devine->dd_dollar, 2, ',', '.') }}&nbsp;$
                          </div>
                        </div>
                        <!-- /DISC/Devine -->
                        <!-- Datum izrade -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-calendar"></i>Datum izrade
                          </label>
                          <div class='form-control'>{{ date("d.m.Y.",strtotime($disc_devine->make_date)) }}</div>
                        </div>
                        <!-- /Datum izrade -->
                        <!-- Datum plaćanja -->
                        <div class='form-group'> 
                          <label class="control-label">
                            <i class="fa fa-btn fa-calendar"></i>Datum plaćanja
                          </label>
                          <div class='form-control'>{{ date("d.m.Y.",strtotime($disc_devine->paid_date)) }}</div>
                        </div>
                        <!-- /Datum plaćanja -->
                        <!-- Srednji kurs dolara-->
                        <div class="form-group{{ $errors->has('middle_ex_dollar') ? ' has-error' : '' }}">
                          <label class="control-label" for="middle_ex_dollar">
                            <i class="fa fa-btn fa-pencil-square-o"></i>Srednji kurs dolara (USD) na dan plaćanja
                          </label>
                          <input type="number" id="middle_ex_dollar" name="middle_ex_dollar" class="form-control" aria-describedby="middle_ex_dollarHelp" placeholder='Unesi srednji kurs dolara (USD) na dan plaćanja' value="{{ old('middle_ex_dollar') }}" step="0.0001">
                          @if ($errors->has('middle_ex_dollar'))
                          <small id="middle_ex_dollarHelp" class="form-text text-danger h5">
                            {{ $errors->first('middle_ex_dollar') }}
                          </small>
                          @endif
                        </div>
                        <!-- /Srednji kurs dolara  -->
                        <!-- DISC/Devine (RSD) -->
                        <div class="form-group{{ $errors->has('dd_din') ? ' has-error' : '' }}">
                          <label class="control-label" for="dd_din">
                            <i class="fa fa-btn fa-calculator"></i>DISC/Devine (RSD)
                          </label>
                          <input type="number" id="dd_din" name="dd_din" class="form-control" aria-describedby="dd_dinHelp" value="{{ old('dd_din') }}" step="0.01">
                          @if ($errors->has('dd_din'))
                          <small id="dd_dinHelp" class="form-text text-danger h5">
                            {{ $errors->first('dd_din') }}
                          </small>
                          @endif
                        </div>
                        <!-- /DISC/Devine (RSD) -->
                        <!-- Porez po odbitku (%) -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-percent"></i>Porez po odbitku (%)
                          </label>
                          <div class='form-control'>
                           {{ number_format($ppo, 2, ',', '.') }}&nbsp;%
                          </div>
                        </div>
                        <!-- /Porez po odbitku (%) -->
                        <!-- Porez po odbitku (RSD) -->
                        <div class="form-group{{ $errors->has('ppo_din') ? ' has-error' : '' }}">
                          <label class="control-label" for="ppo_din">
                            <i class="fa fa-btn fa-calculator"></i>Porez po odbitku (RSD)
                          </label>
                          <input type="number" id="ppo_din" name="ppo_din" class="form-control" aria-describedby="ppo_dinHelp" value="{{ old('ppo_din') }}" step="0.01">
                          @if ($errors->has('ppo_din'))
                          <small id="ppo_dinHelp" class="form-text text-danger h5">
                            {{ $errors->first('ppo_din') }}
                          </small>
                          @endif
                        </div>
                        <!-- /Porez po odbitku (RSD) -->
                        <!-- Disc/Devne dollar hidden  -->
                        <input type="hidden" id='dd_dollar' name="dd_dollar" value="{{ $disc_devine->dd_dollar }}">
                        <!-- /Disc/Devne dollar hidden -->
                        <!-- Porez po odbitku (%) hidden  -->
                        <input type="hidden" id='ppo' name="ppo" value="{{ $ppo }}">
                        <!-- /Porez po odbitku (%) hidden -->
                        <!-- /Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- /Token -->
                        <!-- Button -->
                        <div class="panel panel-default san-light">
                          <button type="submit" id="submit" name="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                              <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>POTVRDI
                          </button>
                        </div>
                        <!--/Button -->
                      </form>
                    </div>

                  </div>
                </div><!-- panel-body  -->

            </div>
        </div>
    </div>
</div>
<div class="container"></div>
@endsection

@section('script')
<script src="/js/disc_devines/disc_devine.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection