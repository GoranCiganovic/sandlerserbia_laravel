<!-- ajax search clients by client status -->  
<div class="panel panel-default">
    <div class="panel-heading san-yell text-left">
    	<div>
    		<span><i class="fa fa-btn {{ $status->global_icon }}" aria-hidden="true"></i>{{ $status->global_name }}</span>
    	</div>
    	<!-- Title -->
        <div class="h3 text-center">  
            <i class="fa fa-btn {{ $status->local_icon }}" aria-hidden="true"></i>{{ $status->local_name }}
        </div>
        <!-- /Title -->	
    </div>
    <div class="panel-body san-yell"> 
        <div class="row filter-container">	
        	<!-- Legal Status ( legal_filter name: client status) -->   	
			<div class="form-group pull-left col-lg-3 col-md-4 col-sm-6 col-xs-12">
		       	<select class="form-control" id="legal_filter" name="{{ $client_status }}">
					@include('clients.filters.legal')
				</select>
	        </div> 	
	        <!-- /Legal Status -->
	        <!-- Sorting  -->
	        <div class="form-group pull-right col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
		       	<select class="form-control" id="sort_filter" name="sort_filter">
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
		@include('clients.paginations.clients', ['paginator' => $clients])
    </div>
</div>     
<!-- /ajax search clients by client status -->



 