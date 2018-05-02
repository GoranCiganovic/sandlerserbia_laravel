@extends('layouts.app')

@section('title', $type['name'])

@section('content')
<div class="container main-container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>Prezentacija
          <!-- Nazad dugme -->
          <a href="{{ url('/client/'.$client->id) }}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Profil</a>
          <!-- /Nazad dugme -->
          <!-- Naslov -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i> {{ $type['name'] }} br. {{  $invoice->$type['number'] }}
          </div>
          <!-- /Naslov -->
          @if (Session::has('message'))
          <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">

          <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("/presentation/update/".$client->id."/".$type['type']."/".$invoice->id) }}'>
            <!-- Vrednost-->
            <div class="form-group{{ $errors->has('value_euro') ? ' has-error' : '' }}">
              <label class="control-label" for="value_euro">
                <i class="fa fa-btn fa-euro"></i>Vrednost u evrima
              </label>
              <input type="number" id="value_euro" name="value_euro" class="form-control" aria-describedby="value_euroHelp" value="{{ $invoice->value_euro }}" step="0.01">
              @if ($errors->has('value_euro'))
              <small id="value_euroHelp" class="form-text text-danger h5">
                {{ $errors->first('value_euro') }}
              </small>
              @endif
            </div>
            <!-- /Vrednost  -->
            <!-- Srednji kurs evra-->
            <div class="form-group{{ $errors->has('exchange_euro') ? ' has-error' : '' }}">
              <label class="control-label" for="exchange_euro">
                <i class="fa fa-btn fa-pencil"></i>Srednji kurs evra 
              </label>
              <div class="form-control">{{ $invoice->exchange_euro }}</div>
              <input type="hidden" id="exchange_euro" name="exchange_euro" class="form-control" aria-describedby="exchange_euroHelp" value="{{ $invoice->exchange_euro }}" step="0.0001">
              @if ($errors->has('exchange_euro'))
              <small id="exchange_euroHelp" class="form-text text-danger h5">
                {{ $errors->first('exchange_euro') }}
              </small>
              @endif
            </div>
            <!-- /Srednji kurs evra  -->
            <!-- Vrednost din -->
            <div class="form-group{{ $errors->has('value_din') ? ' has-error' : '' }}">
              <label class="control-label" for="value_din">
                <i class="fa fa-btn fa-pencil"></i>Vrednost u dinarima 
              </label>
               <div class="value_din form-control">{{ $invoice->value_din }}</div>
              <input type="hidden" id="value_din" name="value_din" class="form-control" aria-describedby="value_dinHelp" value="{{ $invoice->value_din }}" step="0.01">
              @if ($errors->has('value_din'))
              <small id="value_dinHelp" class="form-text text-danger h5">
                {{ $errors->first('value_din') }}
              </small>
              @endif
            </div>
            <!-- /Vrednost  din -->
            <!-- PDV -->
            <div class="form-group{{ $errors->has('pdv') ? ' has-error' : '' }}">
              <label class="control-label" for="pdv">
                <i class="fa fa-btn fa-percent"></i>PDV 
              </label>
              <div class="form-control">{{ $invoice->pdv }}</div>
              <input type="hidden" id="pdv" name="pdv" class="form-control" aria-describedby="pdvHelp" value="{{ $invoice->pdv }}" step="0.01">
              @if ($errors->has('pdv'))
              <small id="pdvHelp" class="form-text text-danger h5">
                {{ $errors->first('pdv') }}
              </small>
              @endif
            </div>
            <!-- /PDV -->
            <!-- PDV din -->
            <div class="form-group{{ $errors->has('pdv_din') ? ' has-error' : '' }}">
              <label class="control-label" for="pdv_din">
                <i class="fa fa-btn fa-pencil"></i>PDV u dinarima 
              </label>
              <div class="pdv_din form-control">{{ $invoice->pdv_din }}</div>
              <input type="hidden" id="pdv_din" name="pdv_din" class="form-control" aria-describedby="pdv_dinHelp" value="{{ $invoice->pdv_din }}" step="0.01">
              @if ($errors->has('pdv_din'))
              <small id="pdv_dinHelp" class="form-text text-danger h5">
                {{ $errors->first('pdv_din') }}
              </small>
              @endif
            </div>
            <!-- /PDV  din -->
            <!-- Vrednost din sa pdv-om -->
            <div class="form-group{{ $errors->has('value_din_tax') ? ' has-error' : '' }}">
              <label class="control-label" for="value_din_tax">
                <i class="fa fa-btn fa-pencil"></i>Vrednost u dinarima sa pdv-om
              </label>
              <div class="value_din_tax form-control">{{ $invoice->value_din_tax }}</div>
              <input type="hidden" id="value_din_tax" name="value_din_tax" class="form-control" aria-describedby="value_din_taxHelp" value="{{ $invoice->value_din_tax }}" step="0.01">
              @if ($errors->has('value_din_tax'))
              <small id="value_din_taxHelp" class="form-text text-danger h5">
                {{ $errors->first('value_din_tax') }}
              </small>
              @endif
            </div>
            <!-- /Vrednost  din sa pdv-om -->
            <!-- Datum izdavanja  -->
            <div class="form-group{{ $errors->has('format_issue_date') ? ' has-error' : '' }}">
              <label class="control-label" for="format_issue_date">
                <i class="fa fa-btn fa-calendar"></i>Datum izdavanja 
              </label>
              <input type="text" id="format_issue_date" name="format_issue_date" class="form-control" aria-describedby="format_issue_dateHelp" value='{{ date("d.m.Y.",strtotime($invoice->issue_date)) }}'>
              <input type="hidden" id="issue_date" name="issue_date" value="{{ $invoice->issue_date }}">
              @if ($errors->has('format_issue_date'))
              <small id="format_issue_dateHelp" class="form-text text-danger h5">
                {{ $errors->first('format_issue_date') }}
              </small>
              @endif
            </div>
            <!-- /Datum izdavanja  -->
            <!-- Datum prometa  -->
            <div class="form-group{{ $errors->has('format_traffic_date') ? ' has-error' : '' }}">
              <label class="control-label" for="format_traffic_date">
                <i class="fa fa-btn fa-calendar"></i>Datum prometa 
              </label>
              <input type="text" id="format_traffic_date" name="format_traffic_date" class="form-control" aria-describedby="format_traffic_dateHelp" value='{{ date("d.m.Y.",strtotime($invoice->traffic_date)) }}'>
              <input type="hidden" id="traffic_date" name="traffic_date" value="{{ $invoice->traffic_date }}">
              @if ($errors->has('format_traffic_date'))
              <small id="format_traffic_dateHelp" class="form-text text-danger h5">
                {{ $errors->first('format_traffic_date') }}
              </small>
              @endif
            </div>
            <!-- /Datum prometa  -->
            <!-- Opis usluge -->
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
              <label class="control-label" for="description">
                <i class="fa fa-btn fa-comment"></i>Opis usluge
              </label>
              <textarea id="description" name="description"  class="form-control" aria-describedby="descriptionHelp" rows="2">{{ $invoice->description }}</textarea>
              @if ($errors->has('description'))
              <small id="descriptionHelp" class="form-text text-danger h5">
                {{ $errors->first('description') }}
              </small>
              @endif
            </div>
            <!-- /Opis usluge -->
            <!-- Napomena -->
            <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
              <label class="control-label" for="note">
                <i class="fa fa-btn fa-comment"></i>Napomena
              </label>
              <textarea id="note" name="note"  class="form-control" aria-describedby="noteHelp" rows="2">{{ $invoice->note }}</textarea>
              @if ($errors->has('note'))
              <small id="noteHelp" class="form-text text-danger h5">
                {{ $errors->first('note') }}
              </small>
              @endif
            </div>
            <!-- /Napomena -->

            <!-- /Token --> 
            <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
            <!-- /Token -->
            <!-- FORM PDF ACTION -->
            <input type="hidden" id='form_pdf_action' name="form_pdf_action" value='{{ url("pdf/".$type['type']."/".$invoice->id."/".$client->id) }}'>
            <!-- /FORM PDF ACTION -->
            <!-- FORM ISSUED ACTION -->
            <input type="hidden" id='form_issued_action' name="form_issued_action" value='{{ url("/presentation/issued/".$client->id."/".$type['type']."/".$invoice->id) }}'>
            <!-- /FORM ISSUED ACTION -->
            <!-- FORM DELETE ACTION -->
            <input type="hidden" id='form_delete_action' name="form_delete_action" value='{{ url("/presentation/delete/".$client->id."/".$type['type']."/".$invoice->id) }}'>
            <!-- /FORM DELETE ACTION -->
            <!-- Button  Update -->
            <div class="panel panel-default san-light">
              <button type="submit" id="submit" name="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>POTVRDI IZMENU  
              </button>
            </div>
            <!--/Button  Update -->
            <!-- Button Issued  -->
            <div class="panel panel-default san-light">
              <button type="submit" id="issued" name="issued" class='button_prevent_multiple_submits btn btn-info btn-md btn-block'>
                <i class="no_spinner fa fa-btn fa-external-link" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>IZDATA <span id="issuedTypeName">{{strtoupper($type['name'])}}</span>
              </button>
            </div>
            <!--/Button  Issued -->
            <!-- Button Delete  -->
            <div class="panel panel-default san-light">
              <button type="submit" id="delete" name="delete" class='button_prevent_multiple_submits btn btn-danger btn-md btn-block'>
                <i class="no_spinner fa fa-btn fa-times" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>OBRIŠI <span id='deleteTypeName'>{{ $type['submit'] }}</span>
              </button>
            </div>
            <!--/Button  Delete -->
            <!-- PDF -->
            <div class="panel panel-default san-light">
              <button type="submit" id="pdf_preview" name="pdf_preview" class='button_prevent_multiple_submits btn btn-default btn-md btn-block'>
                <i class="no_spinner fa fa-btn fa-file-text-o" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>{{ strtoupper($type['name']) }} PDF 
              </button>
            </div>
            <!--/PDF -->
          </form>
      
        </div><!--/panel-body -->

      </div><!-- panel panel-default -->

    </div>
  </div>
</div>
<div class="container"></div>
@endsection

@section('script')
<script src="/js/invoices/presentations/create.js"></script>
<script src="/js/invoices/presentations/pdf.js"></script>
<script src="/js/invoices/confirm_issued.js"></script>
<script src="/js/invoices/confirm_delete.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection

