@extends('layouts.app')

@section('title', $client_status->global_name.' profil' )

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>
                  Profil - {{ $client_status->global_name }}
                  <!-- Back Button -->
                  <a href="{{ url('/client/'.$clientID)}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Profil</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Izmena profila<br>
                    <h5>{{ $legal->long_name }}</h5>
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                  <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>

                <div class="panel-body san-yell">
                  <form method="POST" id='form' action='{{ url("/legal/update/".$legal->id) }}'  class='form_prevent_multiple_submits'>
                    <!-- Naziv -->
                    <div class="form-group{{ $errors->has('long_name') ? ' has-error' : '' }}">
                      <label class="control-label" for="long_name">
                        <i class="fa fa-btn fa-building"></i>Naziv 
                      </label>
                      <input type="text" id="long_name" name="long_name" class="form-control" aria-describedby="long_nameHelp" value="{{ $legal->long_name }}">
                      @if ($errors->has('long_name'))
                      <small id="long_nameHelp" class="form-text text-danger h5">
                        {{ $errors->first('long_name') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Naziv -->
                    <!-- Kraći naziv-->
                    <div class="form-group{{ $errors->has('short_name') ? ' has-error' : '' }}">
                      <label class="control-label" for="short_name">
                        <i class="fa fa-btn fa-building"></i>Kraći naziv
                      </label>
                      <input type="text" id="short_name" name="short_name" class="form-control" aria-describedby="short_nameHelp" value="{{ $legal->short_name }}">
                      @if ($errors->has('short_name'))
                      <small id="short_nameHelp" class="form-text text-danger h5">
                        {{ $errors->first('short_name') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Kraći naziv -->
                    <!-- Komentar -->
                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                      <label class="control-label" for="comment">
                        <i class="fa fa-btn fa-comment"></i>Komentar
                      </label>
                      <textarea id="comment" name="comment"  class="form-control" aria-describedby="commentHelp" rows="5">{{$legal->comment}}</textarea>
                      @if ($errors->has('comment'))
                      <small id="commentHelp" class="form-text text-danger h5">
                        {{ $errors->first('comment') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Komentar -->
                    <!-- Direktor -->
                    <div class="form-group{{ $errors->has('ceo') ? ' has-error' : '' }}">
                      <label class="control-label" for="ceo">
                        <i class="fa fa-btn fa-user"></i>Direktor
                      </label>
                      <input type="text" id="ceo" name="ceo" class="form-control" aria-describedby="ceoHelp" value="{{$legal->ceo}}">
                      @if ($errors->has('ceo'))
                      <small id="ceoHelp" class="form-text text-danger h5">
                        {{ $errors->first('ceo') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Direktor -->
                    <!-- Telefon -->
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                      <label class="control-label" for="phone">
                        <i class="fa fa-btn fa-phone"></i>Telefon
                      </label>
                      <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" value="{{$legal->phone}}">
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
                      <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{$legal->email}}">
                      @if ($errors->has('email'))
                      <small id="emailHelp" class="form-text text-danger h5">
                        {{ $errors->first('email') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Email -->
                    <!-- Lice za razgovor -->
                    <div class="form-group{{ $errors->has('contact_person') ? ' has-error' : '' }}">
                      <label class="control-label" for="contact_person">
                        <i class="fa fa-btn fa-user"></i>Lice za razgovor
                      </label>
                      <input type="text" id="contact_person" name="contact_person" class="form-control" aria-describedby="contact_personHelp" value="{{$legal->contact_person}}">
                      @if ($errors->has('contact_person'))
                      <small id="contact_personHelp" class="form-text text-danger h5">
                        {{ $errors->first('contact_person') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Lice za razgovor -->
                    <!-- Telefon lica za razgovor -->
                    <div class="form-group{{ $errors->has('contact_person_phone') ? ' has-error' : '' }}">
                      <label class="control-label" for="contact_person_phone">
                        <i class="fa fa-btn fa-phone"></i>Telefon lica za razgovor
                      </label>
                      <input type="text" class="form-control" id="contact_person_phone" name="contact_person_phone" aria-describedby="contact_person_phoneHelp" value="{{$legal->contact_person_phone}}">
                      @if ($errors->has('contact_person_phone'))
                      <small id="contact_person_phoneHelp" class="form-text text-danger h5">
                        {{ $errors->first('contact_person_phone') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Telefon lica za razgovor -->
                    <!-- Matični broj firme -->
                    <div class="form-group{{ $errors->has('identification') ? ' has-error' : '' }}">
                      <label class="control-label" for="identification">
                        <i class="fa fa-btn fa-pencil"></i>Matični broj firme
                      </label>
                      <input type="number" id="identification" name="identification" class="form-control" aria-describedby="identificationHelp" value="{{$legal->identification}}">
                      @if ($errors->has('identification'))
                      <small id="identificationHelp" class="form-text text-danger h5">
                        {{ $errors->first('identification') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Matični broj firme -->
                    <!-- PIB-->
                    <div class="form-group{{ $errors->has('pib') ? ' has-error' : '' }}">
                      <label class="control-label" for="pib">
                        <i class="fa fa-btn fa-pencil"></i>PIB
                      </label>
                      <input type="number" id="pib" name="pib" class="form-control" aria-describedby="pibHelp" value="{{$legal->pib}}">
                      @if ($errors->has('pib'))
                      <small id="pibHelp" class="form-text text-danger h5">
                        {{ $errors->first('pib') }}
                      </small>
                      @endif
                    </div>
                    <!-- /PIB -->
                    <!-- Veličina -->
                    <div class="form-group{{ $errors->has('company_size_id') ? ' has-error' : '' }}">
                      <label class="control-label" for="company_size_id">
                        <i class="fa fa-btn fa-th-large"></i>Veličina 
                      </label>
                      <select class="form-control" id="company_size_id" name="company_size_id" aria-describedby="company_size_idHelp">
                        @foreach($company_sizes as $size)
                        <option value="{{ $size->id }}" 
                          @if($size->id == $company_size->id) selected @endif
                        >{{ $size->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('company_size_id'))
                      <small id="company_size_idHelp" class="form-text text-danger h5">
                        {{ $errors->first('company_size_id') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Veličina -->
                    <!-- Delatnost -->
                    <div class="form-group{{ $errors->has('activity') ? ' has-error' : '' }}">
                      <label class="control-label" for="activity">
                        <i class="fa fa-btn fa-industry"></i>Delatnost
                      </label>
                      <input type="text" id="activity" name="activity" class="form-control" aria-describedby="activityHelp" value="{{$legal->activity}}">
                      @if ($errors->has('activity'))
                      <small id="activityHelp" class="form-text text-danger h5">
                        {{ $errors->first('activity') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Delatnost -->
                    <!-- Adresa -->
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                      <label class="control-label" for="address">
                        <i class="fa fa-btn fa-map-marker"></i>Adresa
                      </label>
                      <input type="text" id="address" name="address" class="form-control" aria-describedby="addressHelp" value="{{$legal->address}}">
                      @if ($errors->has('address'))
                      <small id="addressHelp" class="form-text text-danger h5">
                        {{ $errors->first('address') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Adresa -->
                    <!-- Opština -->
                    <div class="form-group{{ $errors->has('county') ? ' has-error' : '' }}">
                      <label class="control-label" for="county">
                        <i class="fa fa-btn fa-map-marker"></i>Opština
                      </label>                    
                      <input type="text" id="county" name="county" class="form-control" aria-describedby="countyHelp" value="{{$legal->county}}">
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
                      <input type="number" id="postal" name="postal" class="form-control" aria-describedby="postalHelp" value="{{$legal->postal}}">
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
                      <input type="text" id="city" name="city" class="form-control" aria-describedby="cityHelp" value="{{$legal->city}}">
                      @if ($errors->has('city'))
                      <small id="cityHelp" class="form-text text-danger h5">
                        {{ $errors->first('city') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Grad -->
                    <!-- Website -->
                    <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                      <label class="control-label" for="website">
                        <i class="fa fa-btn fa-globe"></i>Website
                      </label>
                      <input type="text" id="website" name="website" class="form-control" aria-describedby="websiteHelp" value="{{$legal->website}}">
                      @if ($errors->has('website'))
                      <small id="websiteHelp" class="form-text text-danger h5">
                        {{ $errors->first('website') }}
                      </small>
                      @endif
                    </div>
                    <!-- /Website -->
                    <!-- /Token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- /Token -->
                    <!-- Button -->
                    <div class="panel panel-default san-light">
                      <button type="submit" id="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                          <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>POTVRDI 
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
<script src="/js/legals/legal.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection