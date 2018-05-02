@extends('layouts.app')

@section('title', 'Sandler dug')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2"> 
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-list" aria-hidden="true"></i>Sandler
                  <!-- Back Button -->
                  <a href='{{ url("/home") }}' class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <span class="sandler-systems-icon-lg glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Sandler
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                  <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>

                <div class="panel-body san-yell">

                  @if($sandlers > 0)
                  <div class="panel panel-default san-light">

                    <div class="panel-heading alert-san-grey text-left">
                      <i class="fa fa-btn fa-calendar" aria-hidden="true"></i>Dug za mesec {{$previous_month}}
                    </div>

                    <div class="container-fluid panel-body-sm bg-white">

                      <!-- Datum plaćanja -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Datum plaćanja:
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{$sandler_pay_day}}.{{$now->month}}.{{$now->year}}.
                          </span>
                        </div>
                      </div>
                      <!-- /Datum plaćanja  -->
                      <!-- Broj faktura (RSD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Broj faktura:
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{ $sandlers }}&nbsp;kom
                          </span>
                        </div>
                      </div>
                      <!-- /Broj faktura (RSD)  -->
                      <!--  Vrednost faktura (RSD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Vrednost faktura (RSD):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{ number_format($invoice_din_total,2,',','.') }}&nbsp;din
                          </span>
                        </div>
                      </div>
                      <!-- /Vrednost faktura (RSD)  -->
                      <!-- Srednji kurs dolara -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Srednji kurs dolara (RSD):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                            {{ $exchange_dollar }}&nbsp; din
                          </span>
                        </div>
                      </div>
                      <!-- /Srednji kurs dolara  -->
                      <!-- Kurs obračunat na dan-->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                         Kurs obračunat na dan:
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                            {{ date("d.m.Y.") }}
                          </span>
                        </div>
                      </div>
                      <!-- /Kurs obračunat na dan  -->
                      <!-- Vrednost faktura (USD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Vrednost faktura (USD):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{ number_format($invoice_dollar_total,2,',','.') }}&nbsp;$
                          </span>
                        </div>
                      </div>
                      <!-- /Vrednost faktura (USD)  -->
                      <!-- Sandler procenat -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Sandler procenat (%)
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{ number_format($sandler_percent,2,',','.') }}&nbsp;%
                          </span>
                        </div>
                      </div>
                      <!-- /Sandler procenat -->
                      <!--  Sandler procenat (USD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Sandler procenat (USD):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span class="text-info"> 
                          {{ number_format($sandler_dollar_total,2,',','.') }}&nbsp;$
                          </span>
                        </div>
                      </div>
                      <!-- / Sandler procenat (USD)  -->
                      <!-- Porez po odbitku (%) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Porez po odbitku (%):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{ number_format($ppo,2,',','.') }}&nbsp;%
                          </span>
                        </div>
                      </div>
                      <!-- /Porez po odbitku (%) -->
                      <!-- Porez po odbitku (RSD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Porez po odbitku (RSD):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span class="text-info"> 
                          {{ number_format($ppo_din,2,',','.') }}&nbsp;din
                          </span>
                        </div>
                      </div>
                      <!-- /Porez po odbitku (RSD) -->

                    </div><!-- contariner-fulid panel-body-sm -->
                    
                  </div><!-- panel panel-default san-light -->
                  @else
                  <div class='h4 text-center'>Nema dugovanja za mesec {{$previous_month}}</div>
                  @endif
        
                  <!-- All Sandler unpaid -->
                  @if(count($all_sandler) > 0)
                  <div class="panel panel-default san-light">
                    <div class="panel-heading alert-san-grey text-left">
                      <i class="fa fa-btn fa-edit" aria-hidden="true"></i>Unesi srednji kurs dolara (USD) na dan plaćanja fakture
                    </div> 
                      @foreach($all_sandler as $sandler)
                        <a href='{{ url("/sandler/edit_debt/{$sandler->id}") }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
                          <span class="sandler-systems-icon-lg glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Sandler dug za fakturu br. {{ $sandler->invoice->invoice_number }} izdatu {{ date("d.m.Y.",strtotime($sandler->issued_date)) }} god.
                        </a>
                      @endforeach
                  </div> 
                  @endif
                  <!-- All Sandler unpaid -->
                
                </div><!-- panel-body  -->
            </div><!-- panel panel-default -->

        </div>
    </div>
</div>
<div class="container"></div> 
@endsection

