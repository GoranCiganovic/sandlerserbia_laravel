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
        @if(count($proinvoices) > 0)
          @foreach($proinvoices as $proinvoice)
            <a href='{{ url("payment/".$proinvoice->contract_id."/".$proinvoice->id) }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
              <i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>
              <span>Avans u vrednosti od {{ number_format($proinvoice->value_euro, 2, ',', '.') }} EUR po Ugovoru broj {{$proinvoice->contract_number}} od {{ date("d.m.Y.",strtotime($proinvoice->contract_date)) }} godine.</span>
            </a>
          @endforeach
        @else
        <div class='h4'>Nema</div><br>
        @endif
        @include('invoices.ajax_proinvoices.pagination', ['paginator' => $proinvoices])
      </div>
    </div>
  </div><!-- panel-body  -->
</div>     
<!-- /ajax home issued today --> 