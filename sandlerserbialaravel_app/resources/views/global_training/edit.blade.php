@extends('layouts.app')

@section('title', 'Global Training')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Profil
                  <!-- Back Button -->
                  <a href="@if(url()->current() != url()->previous()){{ url()->previous()}}@else{{ url('/home')}}@endif 
                  " class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Global Training
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>
        
                <div class="panel-body san-yell">
                  <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("/global_training/update/".$global_training->id) }}'>
                    <!-- Naziv -->
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label class="control-label" for="name">
                        <i class="fa fa-btn fa-home"></i>Naziv
                      </label>
                      <input type="text" id="name" name="name" class="form-control" aria-describedby="nameHelp" value="{{ $global_training->name }}">
                      @if ($errors->has('name'))
                      <small id="nameHelp" class="form-text text-danger h5">
                        {{ $errors->first('name') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Naziv -->
                    <!-- Ovalšćeni zastupnik -->
                    <div class="form-group{{ $errors->has('representative') ? ' has-error' : '' }}">
                      <label class="control-label" for="representative">
                        <i class="fa fa-btn fa-user"></i>Ovalšćeni zastupnik
                      </label>
                      <input type="text" id="representative" name="representative" class="form-control" aria-describedby="representativeHelp" value="{{ $global_training->representative }}">
                      @if ($errors->has('representative'))
                      <small id="representativeHelp" class="form-text text-danger h5">
                        {{ $errors->first('representative') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Ovalšćeni zastupnik -->
                    <!-- Telefon -->
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                      <label class="control-label" for="phone">
                        <i class="fa fa-btn fa-phone"></i>Telefon
                      </label>
                      <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" value="{{ $global_training->phone }}">
                      @if ($errors->has('phone'))
                      <small id="phoneHelp" class="form-text text-danger h5">
                        {{ $errors->first('phone') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Telefon -->
                    <!-- Email -->
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label class="control-label" for="email">
                        <i class="fa fa-btn fa-at"></i>Email adresa
                      </label>
                      <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ $global_training->email }}">
                      @if ($errors->has('email'))
                      <small id="emailHelp" class="form-text text-danger h5">
                        {{ $errors->first('email') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Email -->
                    <!-- Website -->
                    <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                      <label class="control-label" for="website">
                        <i class="fa fa-btn fa-globe"></i>Website
                      </label>
                      <input type="text" id="website" name="website" class="form-control" aria-describedby="websiteHelp" value="{{ $global_training->website }}">
                      @if ($errors->has('website'))
                      <small id="websiteHelp" class="form-text text-danger h5">
                        {{ $errors->first('website') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Website -->
                    <!-- Sedište -->
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                      <label class="control-label" for="address">
                        <i class="fa fa-btn fa-map-marker"></i>Sedište
                      </label>
                      <input type="text" id="address" name="address" class="form-control" aria-describedby="addressHelp" value="{{ $global_training->address }}">
                      @if ($errors->has('address'))
                      <small id="addressHelp" class="form-text text-danger h5">
                        {{ $errors->first('address') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Sedište -->
                    <!-- Opština -->
                    <div class="form-group{{ $errors->has('county') ? ' has-error' : '' }}">
                      <label class="control-label" for="county">
                        <i class="fa fa-btn fa-map-marker"></i>Opština
                      </label>
                      <input type="text" id="county" name="county" class="form-control" aria-describedby="countyHelp" value="{{ $global_training->county }}">
                      @if ($errors->has('county'))
                      <small id="countyHelp" class="form-text text-danger h5">
                        {{ $errors->first('county') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Opština -->
                    <!-- Poštanski broj -->
                    <div class="form-group{{ $errors->has('postal') ? ' has-error' : '' }}">
                      <label class="control-label" for="postal">
                        <i class="fa fa-btn fa-pencil"></i>Poštanski broj
                      </label>
                      <input type="number" id="postal" name="postal" class="form-control" aria-describedby="postalHelp" value="{{ $global_training->postal }}">
                      @if ($errors->has('postal'))
                      <small id="postalHelp" class="form-text text-danger h5">
                        {{ $errors->first('postal') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Poštanski broj -->
                    <!-- Grad -->
                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                      <label class="control-label" for="city">
                        <i class="fa fa-btn fa-map-marker"></i>Grad
                      </label>
                      <input type="text" id="city" name="city" class="form-control" aria-describedby="cityHelp" value="{{ $global_training->city }}">
                      @if ($errors->has('city'))
                      <small id="cityHelp" class="form-text text-danger h5">
                        {{ $errors->first('city') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Grad -->
                    <!-- Banka -->
                    <div class="form-group{{ $errors->has('bank') ? ' has-error' : '' }}">
                      <label class="control-label" for="bank">
                        <i class="fa fa-btn fa-bank"></i>Banka
                      </label>
                      <input type="text" id="bank" name="bank" class="form-control" aria-describedby="bankHelp" value="{{ $global_training->bank }}">
                      @if ($errors->has('bank'))
                      <small id="bankHelp" class="form-text text-danger h5">
                        {{ $errors->first('bank') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Banka -->
                    <!-- Račun-->
                    <div class="form-group{{ $errors->has('account') ? ' has-error' : '' }}">
                      <label class="control-label" for="account">
                        <i class="fa fa-btn fa-pencil"></i>Račun
                      </label>
                      <input type="number" id="account" name="account" class="form-control" aria-describedby="accountHelp" value="{{ $global_training->account }}">
                      @if ($errors->has('account'))
                      <small id="accountHelp" class="form-text text-danger h5">
                        {{ $errors->first('account') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Račun -->
                    <!-- PIB-->
                    <div class="form-group{{ $errors->has('pib') ? ' has-error' : '' }}">
                      <label class="control-label" for="pib">
                        <i class="fa fa-btn fa-pencil"></i>PIB
                      </label>
                      <input type="number" id="pib" name="pib" class="form-control" aria-describedby="pibHelp" value="{{ $global_training->pib }}">
                      @if ($errors->has('pib'))
                      <small id="pibHelp" class="form-text text-danger h5">
                        {{ $errors->first('pib') }}
                      </small>
                      @endif
                    </div>
                    <!-- /PIB -->
                    <!-- Matični broj firme -->
                    <div class="form-group{{ $errors->has('identification') ? ' has-error' : '' }}">
                      <label class="control-label" for="identification">
                        <i class="fa fa-btn fa-pencil"></i>Matični broj firme
                      </label>
                      <input type="number" id="identification" name="identification" class="form-control" aria-describedby="identificationHelp" value="{{ $global_training->identification }}">
                      @if ($errors->has('identification'))
                      <small id="identificationHelp" class="form-text text-danger h5">
                        {{ $errors->first('identification') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Matični broj firme -->
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

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container"></div>
@endsection


@section('script')
<script src="/js/global_training/global_training.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection