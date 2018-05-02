@extends('layouts.app')

@section('title', 'PDV')
      
@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-list" aria-hidden="true"></i>PDV
                  <!-- Back Button -->
                  <a href='{{ url("/home") }}' class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                     <i class="fa fa-btn fa-percent" aria-hidden="true"></i>&nbsp;&nbsp;PDV
                  </div>
                  <!-- /Title -->
                </div>

                <div class="panel-body san-yell">

                  @if($invoices > 0)
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
                          {{$pdv_paying_day}}.{{$now->month}}.{{$now->year}}.
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
                          {{ $invoices }}&nbsp;kom
                          </span>
                        </div>
                      </div>
                      <!-- /Broj faktura (RSD)  -->
                      <!--  Vrednost faktura (RSD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Vrednost faktura bez PDV-a:
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{ number_format($pdv_debt->invoice_din_total,2,',','.') }}&nbsp;din
                          </span>
                        </div>
                      </div>
                      <!-- / Vrednost faktura (RSD)  -->
                      <!-- PDV (%) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          PDV (%):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{ number_format($pdv_percent,2,',','.') }}&nbsp;%
                          </span>
                        </div>
                      </div>
                      <!-- /PDV (%) -->
                      <!-- Ukupan iznos sa PDV-om (RSD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          Ukupan iznos sa PDV-om:
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span> 
                          {{ number_format($pdv_debt->value_din_tax_total,2,',','.') }}&nbsp;din
                          </span>
                        </div>
                      </div>
                      <!-- /Ukupan iznos sa PDV-om (RSD)  -->
                      <!-- PDV (RSD) -->
                      <div class="row h5">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                          PDV (RSD):
                        </div>
                        <div class="h1 hidden-lg hidden-md hidden-sm"></div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                          <span class="text-info"> 
                          {{ number_format($pdv_debt->pdv_din_total,2,',','.') }}&nbsp;din
                          </span>
                        </div>
                      </div>
                      <!-- /PDV (RSD) -->

                    </div><!-- contariner-fulid panel-body-sm -->
                  </div><!-- panel panel-default san-light -->
                  @else
                  <div class='h4 text-center'>Nema dugovanja za mesec {{$previous_month}}</div>
                  @endif
        
                </div><!-- panel-body  -->
            </div><!-- panel panel-default -->

        </div>
    </div>
</div>
<div class="container"></div> 
@endsection

