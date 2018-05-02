@extends('layouts.app')

@section('title', 'Učesnik')

@section('content')
<div class="container main-container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-edit" aria-hidden="true"></i>Učesnik
          <!-- Back Button -->
          <a href="{{ url('/participants/'.$contract->id)}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Učesnici</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-user" aria-hidden="true"></i>Učesnik: 
            <span id="confirm_name">{{ $participant->name }}</span>
            <h4>Ugovor br. {{ $contract->contract_number}} od {{ date("d.m.Y.",strtotime($contract->contract_date)) }}</h4>
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
          <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">
         
          <form method="POST" id='form' action='{{ url("/participant/update/".$participant->id) }}' class='form_prevent_multiple_submits'>
            <!-- Ime i prezime -->
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label class="control-label" for="name">
                <i class="fa fa-btn fa-user"></i>Ime i prezime 
              </label>
              <input type="text" id="name" name="name" class="form-control" aria-describedby="nameHelp" value="{{ $participant->name }}">
              @if ($errors->has('name'))
              <small id="nameHelp" class="form-text text-danger h5">
                {{ $errors->first('name') }}
              </small>
              @endif
            </div>
            <!-- /Ime i prezime  -->
            <!-- Pozicija -->
            <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
              <label class="control-label" for="position">
                <i class="fa fa-btn fa-pencil"></i>Pozicija
              </label>
              <input type="text" id="position" name="position" class="form-control" aria-describedby="positionHelp" value="{{ $participant->position }}">
              @if ($errors->has('position'))
              <small id="positionHelp" class="form-text text-danger h5">
                {{ $errors->first('position') }}
              </small>
              @endif
            </div>
            <!-- /Pozicija -->
            <!-- Email -->
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label class="control-label" for="email">
                <i class="fa fa-btn fa-at"></i>Email adresa
              </label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ $participant->email }}">
              @if ($errors->has('email'))
              <small id="emailHelp" class="form-text text-danger h5">
                {{ $errors->first('email') }}
              </small>
              @endif
            </div>
            <!-- /Email -->
           <!-- Telefon -->
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
              <label class="control-label" for="phone">
                <i class="fa fa-btn fa-phone"></i>Telefon
              </label>
              <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" value="{{ $participant->phone }}">
              @if ($errors->has('phone'))
              <small id="phoneHelp" class="form-text text-danger h5">
                {{ $errors->first('phone') }}
              </small>
              @endif
            </div>
            <!-- /Telefon -->
            <!-- Datum izrade Disc Devine  (Contract Status In Progress, Finished or Baned) -->
            @if($contract->contract_status_id != '1')
            <div class="form-group{{ $errors->has('format_dd_date') ? ' has-error' : '' }}">
              <label class="control-label" for="format_dd_date">
                <i class="fa fa-btn fa-calendar"></i>Datum izrade DISC/Devine 
              </label>
              <input type="text" id="format_dd_date" name="format_dd_date" class="form-control" aria-describedby="format_dd_dateHelp" value='@if($participant->dd_date){{ date("d.m.Y.",strtotime($participant->dd_date)) }}@endif'">
              <input type="hidden" id="dd_date" name="dd_date" value="@if($participant->dd_date){{ $participant->dd_date }}@endif">
              @if ($errors->has('format_dd_date'))
              <small id="format_dd_dateHelp" class="form-text text-danger h5">
                {{ $errors->first('format_dd_date') }}
              </small>
              @endif
            </div>
            @endif
            <!-- /Datum izrade Disc Devine (Contract Status In Progress, Finished or Baned) -->
            <!-- /Token -->
            <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
            <!-- /Token -->
            <!-- Button -->
            <div class="panel panel-default san-light">
              <button type="submit" id="submit" name="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                  <i class="no_spinner fa fa-btn fa-check"></i><i class='spinner fa fa-btn fa-spinner fa-spin'></i>POTVRDI 
              </button>
            </div>
            <!--/Button -->
          </form>
            <!-- Delete button if not disc/devine -->
            @if($participant->dd_date == null)
            <div class="panel panel-default san-light">
              <a href='{{ url("/participant/delete/".$contract->id."/".$participant->id) }}' id="delete_participant" class='btn btn-danger btn-block' role='button'>
                <i class="no_spinner fa fa-btn fa-times" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>
                <span>OBRIŠI UČESNIKA</span>
              </a>
            </div>
            @endif
            <!-- /Delete button if not disc/devine -->
        </div><!--/panel-body -->

      </div><!-- panel panel-default -->

    </div>
  </div>
</div>
<div class="container"></div>
@endsection

@section('script')
  <!-- If DISC/Devine Exists (Contract Status In Progress, Finished or Baned) -->
  @if($contract->contract_status_id != '1')
  <script src="/js/participants/edit_participant_dd.js"></script>
  <!-- /If DISC/Devine Exists (Contract Status In Progress, Finished or Baned)  -->
  @else
  <!-- If DISC/Devine Doesn't Exist (Contract Status Unsigned) -->
  <script src="/js/participants/edit_participant.js"></script>
  @endif
  <!-- /If DISC/Devine Doesn't Exist (Contract Status Unsigned) -->

  <script src="/js/participants/delete_participant.js"></script>
  <script src='/js/submits/prevent_multiple_submits.js'></script>
  <script src='/js/submits/spinner.js'></script>
@endsection
