 <!-- ajax home contracts-->
<div class="panel panel-default">
  <div class="panel-heading san-yell text-left">
  	<div>
  		<span><i class="fa fa-btn fa-folder-o" aria-hidden="true"></i>Ugovori</span>
  	</div>
    <!-- Title -->
    <div class="h3 text-center">
        <i class='fa fa-btn {!! $fa_icon !!}' aria-hidden='true'></i>{{ $title }}
    </div>
    <!-- /Title -->
  </div>
  <div class="panel-body san-yell">
    <div class="row">
      <br>
      <div class="col-xs-12 text-center">
        @if(count($contracts) > 0)
          @foreach($contracts as $contract)
            <a href='{{ url("/contract/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
              <i class="fa fa-btn fa-folder-o" aria-hidden="true"></i>
              <span>Ugovor broj {{ $contract->contract_number }} od {{ date("d.m.Y.",strtotime($contract->contract_date)) }} godine.</span>
            </a>
          @endforeach
        @else
        <div class='h4' >Nema</div><br>
        @endif
        @include('contracts.pagination', ['paginator' => $contracts])
      </div>
    </div>
  </div><!-- panel-body  -->
</div>     
<!-- /ajax home contracts -->



