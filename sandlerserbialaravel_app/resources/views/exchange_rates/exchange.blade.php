@extends('layouts.app')

@section('title', 'Kursna lista')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Kursna lista
                  <!-- Back Button -->
                  <a href="@if(url()->current() != url()->previous()){{ url()->previous()}}@else{{ url('/home')}}@endif 
                  " class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Kursna lista na dan {{ date("d.m.Y.") }}
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>
        
                <div class="panel-body san-yell">
                  @foreach($exchange as $currency)
                  <a href='{{ url("/exchange/edit/".$currency->id) }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
                      @if($currency->currency == 'EUR')<span class="eu-flag glyphicon glyphicon-globe"></span>@endif
                      @if($currency->currency == 'USD')<span class="usa-flag glyphicon glyphicon-globe"></span>@endif
                      {{ $currency->currency }}&nbsp;{{ $currency->value }}
                  </a>
                  @endforeach
                  <br>
                  <div class="panel panel-default san-light">
                    <a href="{{config('constants.exchange_url')}}" class="btn btn-default btn-block" target="_blank"><i class="fa fa-btn fa-exchange" aria-hidden="true"></i>Kursna lista Banca Intesa</a>
                  </div>
                  <div class="panel panel-default san-light"> 
                    <a href="http://www.nbs.rs/internet/latinica/index.html" class="btn btn-default btn-block" target="_blank"><i class="fa fa-btn fa-exchange" aria-hidden="true"></i>Kursna lista NBS</a>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

