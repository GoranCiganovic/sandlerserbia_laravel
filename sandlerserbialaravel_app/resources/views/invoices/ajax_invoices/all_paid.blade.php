<!-- ajax home all paid invoices -->
<div class="panel panel-default">
  <div class="panel-heading san-yell text-left">
    <div>
      <span><i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>Fakture</span>
    </div>
    <!-- Title -->
    <div class="h3 text-center">
        <i class='fa fa-btn fa-file-text-o' aria-hidden='true'></i>{{ $title }}
    </div>
    <!-- /Title -->
  </div>
  <div class="panel-body san-yell">
    <div class="row">
      <br>
      <div class="col-xs-12 text-center">
        @if(count($invoices) > 0)
          @foreach($invoices as $invoice)
            <a href='
              @if($invoice->contract_id == 0)
              {{ url("/presentation/show/".$invoice->client_id."/invoice/".$invoice->id) }}
              @else
              {{ url("payment/".$invoice->contract_id."/".$invoice->payment_id) }}
              @endif
            ' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
              <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
              <span>Faktura broj {{ $invoice->invoice_number }} od {{ date("d.m.Y.",strtotime($invoice->issue_date)) }} godine.</span>
            </a>
          @endforeach
        @else
        <div class='h4'>Nema</div><br>
        @endif
        @include('invoices.ajax_invoices.pagination', ['paginator' => $invoices])
      </div>
    </div>
  </div><!-- panel-body  -->
</div>  
<!-- /ajax home all paid invoices -->
