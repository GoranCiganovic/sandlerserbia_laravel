@extends('layouts.app')

@section('title', 'Učesnici')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-list" aria-hidden="true"></i>Učesnici
                  <!-- Back Button -->
                  <a href='{{ url("/contract/".$contract->id) }}' class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Ugovor</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-users" aria-hidden="true"></i>Učesnici Ugovora br. {{ $contract->contract_number}} od {{ date("d.m.Y.",strtotime($contract->contract_date)) }}
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

                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 pull-left text-left">
                        @foreach($participants as $key => $participant)
                        <a href='{{ url("/participant/edit/".$contract->id."/".$participant->id) }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
                            <i class="fa fa-btn fa-user" aria-hidden="true"></i>
                            <!-- Participant Number - Number of current page * 10 - 10 -->
                            <span>Učesnik br. {{ ++$key+($participants->currentPage()*10-10) }}&nbsp; {{$participant->name}}</span>
                        </a>
                        @endforeach
                        @include('participants.pagination', ['paginator' => $participants]) 
                        <br>
                    </div>
					
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 pull-right text-center">
                      @if($contract->contract_status_id == '1' || $contract->contract_status_id == '2')
                      <div class="panel panel-default san-light">
                        <div class="panel-heading alert-san-grey text-left">
                          <i class="fa fa-btn fa-user-plus" aria-hidden="true"></i>Dodavanje učesnika
                        </div>
                        <a href='{{ url("/participant/create/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                            <i class="fa fa-btn fa-user-plus" aria-hidden="true"></i>
                            <span>DODAJ NOVOG UČESNIKA</span>
                        </a>
                      </div>
                      @endif
                    </div>

                  </div>
                </div><!-- panel-body  -->

            </div>
        </div>
    </div>
</div>
<div class="container"></div>
@endsection


