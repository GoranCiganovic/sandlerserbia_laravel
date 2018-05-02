 <!-- ajax conversation ratio -->
@if($result)
<div class="row text-center h4">
	U periodu od <br class="hidden-lg hidden-md hidden-sm">
	<span class="text-info">{{$formated_from}}</span> do <span class="text-info">{{$formated_to}}</span><br>
	<h3>
		<i>Od ukupno <br class="hidden-lg hidden-md hidden-sm">kontaktiranih {{$result->total}} - <br class="hidden-lg hidden-md hidden-sm"><span class='text-info'>Conversation Ratio {{$result->met_percentage}}</span></i>
	</h3>
</div>
<table class="table table-hover">
  	<thead>
	    <tr>
	      <th>Prospects</th>
	      <th class="text-center"><i class="fa fa-btn fa-hashtag" aria-hidden="true"></i></th>
	      <th class="text-center"><i class="fa fa-btn fa-percent" aria-hidden="true"></i></th>
	    </tr>
	  	</thead>
	  	<tbody>
	    <tr>
	      <td>Diskvalifikovan</td>
	      <td class="text-center">{{$result->dsq}}</td>
	      <td class="text-center">{{$result->dsq_percentage}}</td>
	    </tr>
	    <tr>
	      <td>JPB</td>
	      <td class="text-center">{{$result->jpb}}</td>
	      <td class="text-center">{{$result->jpb_percentage}}</td>
	    </tr>
	    <tr>
	      <td>Prihvatio sastanak</td>
	      <td class="text-center">{{$result->met}}</td>
	      <td class="text-center">{{$result->met_percentage}}</td>
	    </tr>
	  	<tr>
	      <td>Ukupno</td>
	      <td class="text-center">{{$result->total}}</td>
	      <td class="text-center">100%</td>
	    </tr>
  	</tbody>
</table>
@else
<div class="row text-center h4">
		U periodu od <br class="hidden-lg hidden-md hidden-sm"><span class="text-info">{{$formated_from}}</span> do <span class="text-info">{{$formated_to}}</span><br class="hidden-lg hidden-md hidden-sm"> nije bilo kontaktiranih.
</div>
@endif
<!-- /ajax conversation ratio -->

