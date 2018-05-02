 <!-- ajax home issued today -->
<div class="panel panel-default">
  <div class="panel-heading san-yell text-left">
  	<div>
  		<span><i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>Rate</span>
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
            <a href='{{ url("payment/".$invoice->contract_id."/".$invoice->id) }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
              <i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>
              <span>Rata u vrednosti od {{$invoice->value_euro}} EUR po Ugovoru broj {{$invoice->contract_number}} od {{ date("d.m.Y.",strtotime($invoice->contract_date)) }} godine.</span>
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
<!-- /ajax home issued today -->