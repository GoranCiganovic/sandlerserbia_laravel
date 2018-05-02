 <!-- ajax disc devine ratio -->
@if($disc_devine->dd_dollar > 0)
<div class="row text-center h4">
	U periodu od <br class="hidden-lg hidden-md hidden-sm">
	<span class="text-info">{{$formated_from}}</span> do <span class="text-info">{{$formated_to}}</span><br>
</div>
<table class="table table-hover">
  	<thead>
	    <tr>
	      <th>DISC/Devine promet</th>
	      <th class="text-center"><i class="fa fa-btn fa-hashtag" aria-hidden="true"></i></th>
	    </tr>
	  	</thead>
	  	<tbody>
	  	<tr>
	      <td>Ukupno testova (kom)</td>
	      <td class="text-center">{{ $disc_devine->disc_devine }}&nbsp;kom</td>
	    </tr>
	   	<tr>
	      <td>DISC/Devine (USD)</td>
	      <td class="text-center">{{ number_format($disc_devine->dd_dollar, 2, ',', '.') }}&nbsp;$</td>
	    </tr>
	    <tr>
	      <td>DISC/Devine (RSD)</td>
	      <td class="text-center">{{ number_format($disc_devine->dd_din, 2, ',', '.') }}&nbsp;din</td>
	    </tr>
	  	<tr>
	      <td>Porez po odbitku (RSD)</td>
	      <td class="text-center">{{ number_format($disc_devine->ppo_din, 2, ',', '.') }}&nbsp;din</td>
	    </tr>
  	</tbody>
</table>
@else
<div class="row text-center h4">
		U periodu od <br class="hidden-lg hidden-md hidden-sm"><span class="text-info">{{$formated_from}}</span> do <span class="text-info">{{$formated_to}}</span><br class="hidden-lg hidden-md hidden-sm"> nije bilo prometa.
</div>
@endif
<!-- /ajax disc devine ratio -->