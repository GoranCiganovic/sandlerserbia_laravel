@extends('layouts.app')

@section('title', 'Sandler dug')

@section('content') 
<div class="container main-container">
    <div class="row"> 
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <span class="sandler-systems-icon glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Sandler
                  <!-- Back Button -->
                  <a href="{{ url('/sandler/debt')}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <span class="sandler-systems-icon-lg glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Sandler dugovanje za fakturu br. {{ $invoice->invoice_number }}
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

                      <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("/sandler/update_debt/".$sandler->id) }}'>
                        <!-- Vrednost fakture (RSD) -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-pencil"></i>Vrednost fakture (RSD)
                          </label>
                          <div class='form-control'>
                            {{ number_format($sandler->invoice_din, 2, ',', '.') }}&nbsp;din
                          </div>
                        </div>
                        <!-- /Vrednost fakture (RSD) -->
                        <!-- Datum izdavanja fakture -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-calendar"></i>Datum izdavanja fakture
                          </label>
                          <div class='form-control'>{{ date("d.m.Y.",strtotime($sandler->issued_date)) }}</div>
                        </div>
                        <!-- /Datum izdavanja fakture -->
                        <!-- Datum plaćanja fakture -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-calendar"></i>Datum plaćanja fakture
                          </label>
                          <div class='form-control'>{{ date("d.m.Y.",strtotime($sandler->paid_date)) }}</div>
                        </div>
                        <!-- /Datum plaćanja fakture -->
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
                        <!-- Sandler procenat (%) -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-percent"></i>Sandler procenat (%)
                          </label>
                          <div class='form-control'>
                           {{ number_format($rate->sandler, 2, ',', '.') }}&nbsp;%
                          </div>
                        </div>
                        <!-- /Sandler procenat (%) -->
                        <!-- Sandler (RSD) -->
                        <div class="form-group{{ $errors->has('sandler_din') ? ' has-error' : '' }}">
                          <label class="control-label" for="sandler_din">
                            <i class="fa fa-btn fa-calculator"></i>Sandler (RSD)
                          </label>
                          <input type="number" id="sandler_din" name="sandler_din" class="form-control" aria-describedby="sandler_dinHelp" value="{{ old('sandler_din') }}" step="0.01">
                          @if ($errors->has('sandler_din'))
                          <small id="sandler_dinHelp" class="form-text text-danger h5">
                            {{ $errors->first('sandler_din') }}
                          </small>
                          @endif
                        </div>
                        <!-- /Sandler (RSD) -->
                        <!-- Sandler (USD) -->
                        <div class="form-group{{ $errors->has('sandler_dollar') ? ' has-error' : '' }}">
                          <label class="control-label" for="sandler_dollar">
                            <i class="fa fa-btn fa-calculator"></i>Sandler (USD)
                          </label>
                          <input type="number" id="sandler_dollar" name="sandler_dollar" class="form-control" aria-describedby="sandler_dollarHelp" value="{{ old('sandler_dollar') }}" step="0.01">
                          @if ($errors->has('sandler_dollar'))
                          <small id="sandler_dollarHelp" class="form-text text-danger h5">
                            {{ $errors->first('sandler_dollar') }}
                          </small>
                          @endif
                        </div>
                        <!-- /Sandler (USD) -->
                        <!-- Porez po odbitku (%) -->
                        <div class='form-group'>
                          <label class="control-label">
                            <i class="fa fa-btn fa-percent"></i>Porez po odbitku (%)
                          </label>
                          <div class='form-control'>
                           {{ number_format($rate->ppo, 2, ',', '.') }}&nbsp;%
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
                        <!-- Invoice (RSD) hidden  -->
                        <input type="hidden" id='invoice_din' name="invoice_din" value="{{ $sandler->invoice_din }}">
                        <!-- /Invoice (RSD) hidden -->
                        <!-- Sandler percent (%) hidden  -->
                        <input type="hidden" id='sandler_percent' name="sandler_percent" value="{{ $rate->sandler }}">
                        <!-- /Sandler percent (%) hidden -->
                        <!-- Porez po odbitku (%) hidden  -->
                        <input type="hidden" id='ppo' name="ppo" value="{{ $rate->ppo }}">
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
<script src="/js/sandlers/sandler.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection