 <!-- ajax statistics-->
<div class="panel panel-default">
    <div class="panel-heading san-yell text-left">
    	<div>
    		<span><i class="fa fa-btn fa-bar-chart" aria-hidden="true"></i>Statistika</span>
    	</div>
      <!-- Title -->
      <div class="h3 text-center">
          {!! $fa_icon !!}{{ $title }}
      </div>
      <!-- /Title -->
    </div>
    <div class="panel-body san-yell">
    	<div class="row">
			     <div class="form-group">
            <form method="GET" id='form' action='#'>
  				    <!-- Datum od -->
  				    <div class="form-group col-lg-5 col-md-6 col-sm-6">
  	                <label class="control-label" for="from">
  	                        <i class="fa fa-btn fa-calendar"></i>Datum od
  	                </label>
  	                <input type="text" id="from" name="from" class="form-control" placeholder="Unesi početni datum">
  	                <input type="hidden" id="checkFrom" name='checkFrom'>
  	                <small class="form-text text-danger h5"></small>   
  	            </div>
  	            <!-- /Datum od -->
  	            <!-- Datum do --> 
  	            <div class="col-lg-5 col-md-6 col-sm-6">
  	                <label class="control-label" for="to">
  	                        <i class="fa fa-btn fa-calendar"></i>Datum do
  	                </label>
  	                <input type="text" id="to" name="to" class="form-control" placeholder="Unesi krajnji datum">
  	                <input type="hidden" id="checkTo"  name="checkTo">
  	                <small class="form-text text-danger h5"></small>
                  </div>
                  <!-- Datum do -->
                 	<!-- Button -->
                 	<div class="col-lg-2 col-md-12 col-sm-12">
                 		<label class="control-label">&nbsp;</label>
                  	<a href="{{ $submit }}" id="submit" class='form-control btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-check"></i><span>Potvrdi</span></a>
                 	</div>
                  <!--/Button -->
              </form>
            </div>
        </div>
        <div id="statistics_result"></div>
    </div>
</div>     
<!-- /ajax statistics -->

<script src="/js/statistics/range.js"></script>
