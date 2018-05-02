@extends('layouts.app')

@section('title', 'DISC/Devine dug')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-list" aria-hidden="true"></i>DISC/Devine
                  <!-- Back Button -->
                  <a href='{{ url("/home") }}' class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <span class="disc-devine-icon-lg glyphicon glyphicon-globe"></span>&nbsp;&nbsp;DISC/Devine 
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                  <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>

                <div class="panel-body san-yell">

                  @if($disc_devines > 0)
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
                          {{$dd_pay_day}}.{{$now->month}}.{{$now->year}}.
                          </span>
                        </div>
                      </div>
                      <!-- /Datum plaćanja  -->
                      <!-- Testova -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Testova:
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                           {{$disc_devines}}&nbsp;kom
                          </span>
                        </div>
                      </div>
                      <!-- /Testova  -->
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
                      <!-- Vrednost Testova (USD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Vrednost Testova (USD):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span class="text-info"> 
                          {{ number_format($dd_dollar_total,2,',','.') }}&nbsp;$
                          </span>
                        </div>
                      </div>
                      <!-- /Vrednost Testova (USD)  -->
                      <!-- Vrednost Testova (RSD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Vrednost Testova (RSD):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{ number_format($dd_din_total,2,',','.') }}&nbsp;din
                          </span>
                        </div>
                      </div>
                      <!-- /Vrednost Testova (RSD)  -->
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
                  
                  <!-- All Disc/Devine unpaid -->
                  @if(count($all_disc_devine) > 0)
                  <div class="panel panel-default san-light">
                    <div class="panel-heading alert-san-grey text-left">
                      <i class="fa fa-btn fa-edit" aria-hidden="true"></i>Unesi srednji kurs dolara (USD) na dan plaćanja DISC/Devine testa
                    </div> 
                      @foreach($all_disc_devine as $dd)
                        <a href='{{ url("/disc_devine/edit_debt/{$dd->id}") }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
                          <span class="disc-devine-icon glyphicon glyphicon-globe"></span>&nbsp;&nbsp;DISC/Devine test - {{ $dd->participant->name }} urađen {{ date("d.m.Y.",strtotime($dd->make_date)) }} god.
                        </a>
                      @endforeach
                  </div> 
                  @endif
                  <!-- All Disc/Devine unpaid -->
                
                </div><!-- panel-body  -->
            </div><!-- panel panel-default -->

        </div>
    </div>
</div>
<div class="container"></div>
@endsection

