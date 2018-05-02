 <!-- ajax sandler traffic -->
@if($sandler->sandler_dollar > 0)
<div class="row text-center h4">
	U periodu od <br class="hidden-lg hidden-md hidden-sm">
	<span class="text-info">{{$formated_from}}</span> do <span class="text-info">{{$formated_to}}</span><br>
</div>
<table class="table table-hover">
  	<thead>
	    <tr>
	      <th>Sandler procenat</th>
	      <th class="text-center"><i class="fa fa-btn fa-hashtag" aria-hidden="true"></i></th>
	    </tr>
	  	</thead>
	  	<tbody>
	  	<tr>
	      <td>Ukupno faktura (kom)</td>
	      <td class="text-center">{{ $sandler->invoice }}&nbsp;kom</td>
	    </tr>
	   	<tr>
	      <td>Vrednost faktura (RSD)</td>
	      <td class="text-center">{{ number_format($sandler->invoice_din, 2, ',', '.') }}&nbsp;din</td>
	    </tr>
	   	<tr>
	      <td>Sandler procenat (USD)</td>
	      <td class="text-center">{{ number_format($sandler->sandler_dollar, 2, ',', '.') }}&nbsp;$</td>
	    </tr>
	  	<tr>
	      <td>Porez po odbitku (RSD)</td>
	      <td class="text-center">{{ number_format($sandler->ppo_din, 2, ',', '.') }}&nbsp;din</td>
	    </tr>
  	</tbody>
</table>
@else
<div class="row text-center h4">
		U periodu od <br class="hidden-lg hidden-md hidden-sm"><span class="text-info">{{$formated_from}}</span> do <span class="text-info">{{$formated_to}}</span><br class="hidden-lg hidden-md hidden-sm"> nije bilo prometa.
</div>
@endif
<!-- /ajax sandler traffic --> 