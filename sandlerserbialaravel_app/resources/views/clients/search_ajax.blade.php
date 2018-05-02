<!-- ajax search result --> 
<div class="panel panel-default">
    <div class="panel-heading san-yell text-left">
    	<div>
    		<span><i class="fa fa-btn fa-search" aria-hidden="true"></i>Pretraga</span>
    	</div>
        <!-- Title --> 
        <div class="h3 text-center">
            <i class="fa fa-btn fa-list" aria-hidden="true"></i>Rezultat pretrage
        </div>
        <!-- /Title -->
    </div>
    <div class="panel-body san-yell">
    	<div class="row filter-container">	
        	<!-- Legal Status  -->   	
			<div class="form-group pull-left col-lg-3 col-md-4 col-sm-6 col-xs-12">
		       	<select class="form-control" id="legal_filter_search" name="legal_filter_search">
					@include('clients.filters.legal')
				</select>
	        </div> 	
	        <!-- /Legal Status -->
	        <!-- Sorting  -->
	        <div class="form-group pull-right col-lg-3 col-md-4 col-sm-6 col-xs-12">  
		       	<select class="form-control" id="sort_filter_search" name="sort_filter_search">
					@include('clients.filters.sort')
				</select>
	        </div> 
	        <!-- /Sorting -->
		</div>
        @if($clients->count())
			@foreach($clients as $client)
			<a href="{{ url('/client/'.$client->id) }}"  class='btn btn-primary btn-sm btn-block btn-text-left' role='button'><i class="fa fa-btn {{ $client->legal_icon }}" aria-hidden="true"></i>
				<span>{{ $client->legal_name.$client->individual_name }}</span>
			</a>
			@endforeach
		@else
		    <div class="text-info h3 text-center">Nema rezultata</div>
		@endif
		@include('clients.paginations.search', ['paginator' => $clients])
    </div>
</div>     
<!-- /ajax search result -->













