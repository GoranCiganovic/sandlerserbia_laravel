@extends('layouts.app')

@section('title', 'Ugovor br.'.$contract->contract_number)

@section('content')
<div class="container main-container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Ugovor
          <!-- Back Button -->
          <a href="{{ url('/contract/'.$contract->id)}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Izmena opisa Ugovora br. {{$contract->contract_number}}
            <h5>
              @if($client->long_name){{ $client->long_name }} @endif
              @if($client->first_name){{ $client->first_name." ".$client->last_name }} @endif
            </h5>       
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">
         
          <form method="POST" id='form' action='{{ url("/contract/update_description/".$contract->id) }}' class='form_prevent_multiple_submits'>

            <!-- Opis Ugovora -->
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
              <label class="control-label" for="description">
                <i class="fa fa-btn fa-comment"></i>Opis Ugovora
              </label>
              <textarea id="description" name="description"  class="form-control" aria-describedby="descriptionHelp" rows="5">{{ $contract->description }}</textarea>
              @if ($errors->has('description'))
              <small id="descriptionHelp" class="form-text text-danger h5">
                {{ $errors->first('description') }}
              </small>
              @endif
            </div>
            <!-- /Opis Ugovora -->
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
      
        </div><!--/panel-body -->

      </div><!-- panel panel-default -->

    </div>
  </div>
</div>
<div class="container"></div>
@endsection

@section('script')
<script src="/js/contracts/add_description.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection
