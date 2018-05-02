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
            <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>{{ $type['name'] }} br. {{  $invoice->$type['number'] }}
          </div>
          <!-- /Naslov -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">
            <div class="panel panel-default san-light">
              <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("pdf/".$type['type']."/".$invoice->id."/".$client->id) }}'>  
                <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}"> 
                <button type="submit" id="pdf" name="pdf_preview" class="button_prevent_multiple_submits btn btn-default btn-md btn-block">
                <i class="no_spinner fa fa-btn fa-file-text-o" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>{{ $type['name'] }} PDF 
                </button>
              </form>
            </div>
            @if($invoice->is_paid == '0')
            <div class="panel panel-default san-light">
              <form method="GET" id={{ "form_".$type['type']."_paid" }} class='form_prevent_multiple_submits' action='{{ url("/presentation/paid/".$client->id."/".$type['type']."/".$invoice->id) }}'>     
                  <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                  <button type="submit" id={{'paid_'.$type['type']}} name={{'paid_'.$type['type']}} class='button_prevent_multiple_submits btn btn-info btn-md btn-block'> 
                     <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>POTVRDI PLAĆANJE
                  </button>
              </form>
            </div>
              @if($type['type'] == 'proinvoice')
              <div class="panel panel-default san-light">
                <form method="GET" id="form_payment_delete" class='form_prevent_multiple_submits' action='{{ url("/presentation/delete/".$client->id."/".$type['type']."/".$invoice->id) }}'>      
                  <button type="submit" id="delete" name="delete" class='button_prevent_multiple_submits btn btn-danger btn-md btn-block'>
                      <i class="no_spinner fa fa-btn fa-times" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>OBRIŠI <span id='deleteTypeName'>{{ $type['submit'] }}</span> 
                  </button>
                </form>
              </div>
              @endif
            @endif

        </div><!--/panel-body -->

      </div><!-- panel panel-default -->

    </div>
  </div>
</div>
<div class="container"></div>
@endsection

@section('script')
<script src="/js/invoices/confirm_paid.js"></script>
<script src="/js/invoices/confirm_delete.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection
