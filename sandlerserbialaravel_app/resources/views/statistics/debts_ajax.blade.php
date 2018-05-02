 <!-- ajax debts -->
<div class="panel panel-default">
  <div class="panel-heading san-yell text-left">
  	<div>
  		<span><i class="fa fa-btn fa-list" aria-hidden="true"></i>Dugovanja</span>
  	</div>
    <!-- Title -->
    <div class="h3 text-center">
     <i class="fa fa-btn fa-file-powerpoint-o" aria-hidden="true"></i>Dugovanja za mesec {{ $previous_month }}
    </div>
    <!-- /Title -->
  </div>
  <div class="panel-body san-yell">
    <div class="row">
      <br>
      <div class="col-xs-12 text-center">
          @if($pdv > 0)
            <a href='{{ url("/pdv/debt") }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
              <i class="fa fa-btn fa-percent" aria-hidden="true"></i>&nbsp;&nbsp;PDV
            </a>
          @endif

          @if($sandler > 0)
            <a href='{{ url("/sandler/debt") }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
              <span class="sandler-systems-icon glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Sandler
              @if($non_calc_sandler > 0)<span class="alert-san-grey badge"><b class='text-danger'>!</b></span>@endif
            </a>
          @endif

          @if($disc_devine > 0)
            <a href='{{ url("/disc_devine/debt") }}' class='panel-body-sm btn btn-primary btn-block btn-text-left' role='button'>
              <span class="disc-devine-icon glyphicon glyphicon-globe"></span>&nbsp;&nbsp;DISC/Devine
              @if($non_calc_dd > 0)<span class="alert-san-grey badge"><b class='text-danger'>!</b></span>@endif
            </a>
          @endif

          @if(!$pdv and !$disc_devine and !$sandler)
          <div class='h4 text-center'>Nema</div>
          @endif
          <br>
      </div>

    </div>
  </div>
</div>     
<!-- /ajax debts -->


 

    
