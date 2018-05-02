@extends('layouts.app')

@section('title', 'Rata Ugovora')

@section('content')
<div class="container main-container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1 col-sm-12">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

           <i class="fa fa-btn fa-list" aria-hidden="true"></i>Rata
          <!-- Back Button -->
          <a href='{{ url("/payments/".$contract->id) }}' class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Rate</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
            @if($payment->is_advance == '1') Avans @else Rata @endif 
            Ugovora br. {{$contract->contract_number}} od {{ date("d.m.Y.",strtotime($contract->contract_date)) }}       
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">
          <div class="row">   

            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 pull-left text-left">

                <!-- Table -->
                <table class="table table-hover">

                    <thead>
                      <!-- Rata  -->
                      <tr>
                        <th class='col-xs-5 col-sm-5 col-md-4'>
                          <i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>Status
                        </th>
                        <th class="h5 text-center">{!! $payment_status !!}</th>
                      </tr>
                      <!-- /Rata  -->
                    </thead>

                    <tbody>

                      <!-- /Vrednost  -->
                      <tr>
                        <td>&nbsp;<i class="fa fa-btn fa-eur"></i>&nbsp;Vrednost:</td>
                        <td class="text-center">
                          <span>{{ number_format($payment->value_euro, 2, ',', '.') }} &euro;</span>
                        </td>
                      </tr>
                      <!-- /Vrednost  -->

                      <!-- Datum plaćanja -->
                      <tr>
                        <td><i class="fa fa-btn fa-calendar"></i>Datum plaćanja:</td>
                        <td class="text-center">
                          <span>{{date("d.m.Y.",strtotime($payment->pay_date)) }}</span>
                        </td>
                      </tr>
                      <!-- /Datum plaćanja -->

                      <!-- Opis plaćanja -->
                      <tr>
                        <td><i class="fa fa-btn fa-pencil"></i>Opis plaćanja:</td>
                        <td class="text-center">
                          <span>{{$payment->pay_date_desc}}</span>
                        </td>
                      </tr>
                      <!-- /Opis plaćanja -->

                      <!-- Opis usluge -->
                      <tr>
                        <td><i class="fa fa-btn fa-pencil"></i>Opis usluge:</td>
                        <td class="text-center">
                          <span>{{$payment->description}}</span>
                        </td>
                      </tr>
                      <!-- /Opis usluge -->
              
                    </tbody>

                </table>
                <!-- /Table -->

            </div><!-- /col-lg-7 col-md-7 col-sm-7 col-xs-12 pull-left text-left -->

            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 pull-right text-center">
              <!-- If Payment Is Advnace -->
              @if($payment->is_advance == '1')
                  <!-- If Proinvoice Doesn't Exist and Invoice Doesn't Exist -->
                  @if(!$proinvoice and !$invoice)
                    <div class="panel panel-default san-light">
                      <div class="panel-heading alert-san-grey text-left">
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>Profaktura
                      </div>
                      <a href='{{ url("/create/proinvoice/".$contract->id."/".$payment->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                          <span>NAPRAVI PROFAKTURU</span>
                      </a>
                    </div><!-- /panel panel-default san-light -->
                  <!-- /If Proinvoice Doesn't Exist and Invoice Doesn't Exist -->
                  @elseif($proinvoice and $proinvoice->is_issued == '0')
                  <!-- If Proinvoice Exists and Is Not Issued -->
                    <div class="panel panel-default san-light">
                      <div class="panel-heading alert-san-grey text-left">
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>Profaktura
                      </div>
                      <a href='{{ url("/edit/proinvoice/".$contract->id."/".$payment->id."/".$proinvoice->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                          <span>IZMENI PROFAKTURU {{ $proinvoice->proinvoice_number }}</span>
                      </a>
                    </div><!-- /panel panel-default san-light -->
                  <!-- /If Proinvoice Exists and Is Not Issued -->
                  @elseif($proinvoice and $proinvoice->is_issued == '1' and $proinvoice->is_paid == '0')
                  <!-- If Proinvoice Exists, Is Issued and Proinvoice Is Not Paid -->
                    <div class="panel panel-default san-light">
                      <div class="panel-heading alert-san-grey text-left">
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>Profaktura
                      </div>
       
                      <form method="POST" action='{{ url("/pdf/proinvoice/".$proinvoice->id."/".$contract->client_id) }}'>    
                        <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                        <button type="submit" id="pdf_preview" name="pdf_preview" class='button_prevent_multiple_submits btn btn-default btn-md btn-block'>
                        <i class="no_spinner fa fa-btn fa-file-text-o" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>PROFAKTURA PDF {{ $proinvoice->proinvoice_number }}
                        </button>
                      </form>
                      <form method="GET" id='form_proinvoice_paid' action='{{ url("/proinvoice/paid/".$contract->id."/".$payment->id."/".$proinvoice->id) }}'>     
                        <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                        <button type="submit" id="paid_proinvoice" name="paid_proinvoice" class='button_prevent_multiple_submits btn btn-info btn-md btn-block'> 
                        <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>PLAĆENA PROFAKTURA {{ $proinvoice->proinvoice_number }}
                        </button>
                      </form>
                      <form method="GET" id='form_payment_delete' action='{{ url("/proinvoice/delete/".$contract->id."/".$payment->id."/".$proinvoice->id) }}'>     
                      <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">     
                      <button type="submit" id="delete" name="delete" class='button_prevent_multiple_submits btn btn-danger btn-md btn-block'>
                          <i class="no_spinner fa fa-btn fa-times" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>OBRIŠI <span id='deleteTypeName'>PROFAKTURU</span>
                      </button>
                      </form>

                    </div><!-- /panel panel-default san-light -->
                  <!-- /If Proinvoice Exists, Is Issued and Proinvoice Is Not Paid -->
                  @elseif($proinvoice and $proinvoice->is_paid == '1')
                  <!-- If Proinvoice Is Paid -->
                    <div class="panel panel-default san-light">
                      <div class="panel-heading alert-san-grey text-left">
                        <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>Faktura
                      </div>
                      <form method="POST" action='{{ url("/pdf/proinvoice/".$proinvoice->id."/".$contract->client_id) }}'>    
                        <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                        <button type="submit" id="pdf_preview" name="pdf_preview" class='button_prevent_multiple_submits btn btn-default btn-md btn-block'>
                        <i class="no_spinner fa fa-btn fa-file-text-o" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>PROFAKTURA PDF {{ $proinvoice->proinvoice_number }}
                        </button>
                      </form>
                      <!-- If Invoice Is Not Issued -->
                      @if($invoice->is_issued == '0')
                        <a href='{{ url("/invoice/create_from_proinvoice/".$contract->id."/".$payment->id."/".$proinvoice->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                            <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                            <span>NAPRAVI FAKTURU</span>
                        </a>
                      <!-- /If Invoice Is Not Issued -->
                      @else
                      <!-- If Invoice Is Issued and Paid-->
                      <form method="POST" action='{{ url("/pdf/invoice/".$invoice->id."/".$contract->client_id) }}'>    
                        <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                        <button type="submit" id="pdf_inv_preview" name="pdf_inv_preview" class='button_prevent_multiple_submits btn btn-default btn-md btn-block'>
                        <i class="no_spinner fa fa-btn fa-file-text-o" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>FAKTURA PDF {{ $invoice->invoice_number }}
                        </button>
                      </form>
                      @endif
                      <!-- /If Invoice Is Issued and Paid-->
                    </div><!-- /panel panel-default san-light -->
                    <!-- /If Proinvoice Is Paid -->
                  @endif
              <!-- /If Payment Is Advnace -->
              @else
              <!-- If Payment Is Not Advnace -->
                  <div class="panel panel-default san-light">
                    <div class="panel-heading alert-san-grey text-left">
                      <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>Faktura
                    </div>
                    <!-- If Invoice Doesn't Exist -->
                    @if(!$invoice)
                      <a href='{{ url("/create/invoice/".$contract->id."/".$payment->id) }}' class=' panel-body-sm btn btn-primary btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                          <span>NAPRAVI FAKTURU</span>
                      </a>
                    <!-- /If Invoice Doesn't Exist -->
                    @else
                    <!-- If Invoice Exists -->
                      <form method="POST" action='{{ url("/pdf/invoice/".$invoice->id."/".$contract->client_id) }}'>
                        <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                        <button type="submit" id="pdf_inv_preview" name="pdf_inv_preview" class='button_prevent_multiple_submits btn btn-default btn-md btn-block'>
                         <i class="no_spinner fa fa-btn fa-file-text-o" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>FAKTURA PDF {{ $invoice->invoice_number }}
                        </button>
                      </form>
                      <!-- If Invoice Exist and Not Issued -->
                      @if($invoice and $invoice->is_issued == '0')
                        <a href='{{ url("/edit/invoice/".$contract->id."/".$payment->id."/".$invoice->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                            <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                            <span>IZMENI FAKTURU {{ $invoice->invoice_number}}</span>
                        </a>
                      @endif
                      <!-- /If Invoice Exist and Not Issued -->
                      <!-- If Invoice Exist, Is Issued and Not Paid -->
                      @if($invoice and $invoice->is_issued == '1' and $invoice->is_paid == '0')
                        <form method="GET" id='form_invoice_paid' action='{{ url("/invoice/paid/".$contract->id."/".$payment->id."/".$invoice->id) }}'>   
                          <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                          <button type="submit" id="paid_invoice" name="paid_invoice" class='button_prevent_multiple_submits btn btn-info btn-md btn-block'>
                          <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>PLAĆENA FAKTURA {{ $invoice->invoice_number }}
                          </button>
                        </form>
                      @endif
                      <!-- /If Invoice Exist, Is Issued and Not Paid -->
                    @endif
                    <!-- /If Invoice Exists -->
                  </div><!-- /panel panel-default san-light -->
              @endif
              <!-- /If Payment Is Not Advnace -->
            </div><!-- /col-lg-5 col-md-5 col-sm-5 col-xs-12 pull-right text-center -->

          </div><!-- /row -->

        </div><!--/panel-body -->

      </div><!-- /panel panel-default -->

    </div><!-- /col-md-10 col-md-offset-1 col-sm-12 -->
  </div><!-- /row -->
</div><!-- /container main-container -->
<div class="container"></div>
@endsection

@section('script')
<script src="/js/invoices/confirm_delete.js"></script>
<script src="/js/invoices/confirm_paid.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection