@extends('layouts.app')

@section('title', 'Rate Ugovora')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
              
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-list" aria-hidden="true"></i>Rate
                  <!-- Back Button -->
                  <a href='{{ url("/contract/".$contract->id) }}' class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Ugovor</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>Rate Ugovora br. {{ $contract->contract_number}} od {{ date("d.m.Y.",strtotime($contract->contract_date)) }}
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
                        @foreach($payments as $key => $payment)
                        <a href='{{ url("/payment/edit/".$contract->id."/".$payment['id']) }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
                            <i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>
                            <span>
                            @if($payment['is_advance'] == '1')
                            Avans  
                            @else
                            Rata
                            @endif 
                            &nbsp;{{ date("d.m.Y.",strtotime($payment['pay_date'])) }}&nbsp;{{ $payment['pay_date_desc'] }}
                          </span>
                        </a>
                        @endforeach
                    </div>
                     @include('payments.pagination', ['paginator' => $payments])
                     <br>
                  </div>
                </div><!-- panel-body  -->

            </div>
        </div>
    </div>
</div>
<div class="container"></div>
@endsection


