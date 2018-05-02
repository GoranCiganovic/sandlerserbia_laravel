@extends('layouts.app')

@section('title', 'Unos preko fajla')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Unos
                  <!-- Back Button -->
                  <a href="@if(url()->current() != url()->previous()){{ url()->previous()}}@else{{ url('/home')}}@endif 
                  " class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-building-o" aria-hidden="true"></i>Suspects - pravna lica preko fajla      
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                    <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- Message -->
                </div>
        
                <div class="panel-body san-yell">

                  <form action="{{ url('/legal/store_file') }}" id='form' method="POST" enctype="multipart/form-data" class='form_prevent_multiple_submits'>

                    <!-- Uputstvo-->
                    <div class="form-group">
                      <label class="control-label">
                        <i class="fa fa-btn fa-file-text-o"></i>Uputstvo
                      </label>
                      <div >
                        <ul class="list-group">
                          <li class="list-group-item san-yell text-primary">
                            <h4>Unos u bazu podataka preko fajla traba da poštuje sledeća pravila:</h4>
                            <h5>Dozvoljene ekstenzije fajlova su: &nbsp; <span class="text-san-yell">XLS, XLSX, XLA, XLAM, XLSM, XLT, XLTX, XLTM</span> &nbsp;(EXCEL ekstenzije)</h5>
                            <h5>Naslovne ćelije treba da odgovaraju sledećim nazivima:<h5>
                            <h4><i class="text-info">Naziv, &nbsp;Direktor, &nbsp;Telefon, &nbsp;Email, &nbsp;Lice za razgovor, &nbsp;Telefon lica za razgovor, &nbsp;Matični broj firme, &nbsp;PIB, &nbsp;Delatnost, &nbsp;Veličina, &nbsp;Adresa, &nbsp;Opština, &nbsp;Poštanski broj, &nbsp;Grad, &nbsp;Website</i></h4>

                          </li>
                        </ul>
                      </div>
                    </div>
                    <!-- /Uputstvo-->
                    <!-- Excel fajl-->
                    <div class="form-group{{ $errors->has('excel_file') ? ' has-error' : '' }}">
                      <label class="control-label pick_excel" for="excel_file">
                        <i class="fa fa-btn fa-file-excel-o"></i>Excel
                      </label>
                      <label class="excel_label btn btn-default btn-block text-primary">
                        <span class='pick_excel'>Izaberi Excel fajl</span>
                        <input type="file" id="excel_file" name="excel_file" class="form-control">
                      </label> 
                      <small id='excel_error' class='form-text h5 text-danger'></small>
                      @if($errors->has())
                        @foreach ($errors->all() as $error)
                            <small class="form-text text-danger h5">
                              <div>{{ $error }}</div>
                            </small>
                        @endforeach
                      @endif
                    </div>
                    <!-- /Excel fajl -->
                    <!-- Current Time For Single Submit -->
                    <input type="hidden" name="single_submit" value="{{ $current_time }}">
                    <!-- /Current Time For Single Submit -->
                    <!-- /Token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- /Token -->
                    <!-- Button -->
                    <div class="panel panel-default san-light">
                      <button type="submit" id="submit" name="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
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
@endsection

@section('script')
<script src="/js/legals/from_file.js"></script>
@endsection