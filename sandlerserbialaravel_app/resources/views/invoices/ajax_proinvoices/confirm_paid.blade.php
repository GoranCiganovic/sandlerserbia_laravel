 <!-- ajax home confirm paid proinvoices-->
<div class="panel panel-default">
  <div class="panel-heading san-yell text-left">
  	<div>
  		<span><i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>Profakture</span>
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
            <!-- Different URL Based On Proinvoice type (Presentation or Contract) -->
            <a href='
              @if($proinvoice->contract_id == 0)
                {{ url("/presentation/show/".$proinvoice->client_id."/proinvoice/".$proinvoice->id) }}
              @else
                {{ url("payment/".$proinvoice->contract_id."/".$proinvoice->payment_id) }}
              @endif
              ' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
              <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
              <span>Profaktura broj {{ $proinvoice->proinvoice_number }} od {{ date("d.m.Y.",strtotime($proinvoice->issue_date)) }} godine.</span>
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
<!-- /ajax home confirm paid proinvoices -->