<!-- ajax total traffic -->
@if($total->total_euro > 0)
<div class="row text-center h4">
	U periodu od <br class="hidden-lg hidden-md hidden-sm">
	<span class="text-info">{{$formated_from}}</span> do <span class="text-info">{{$formated_to}}</span><br>
</div>
<table class="table table-hover">
  	<thead>
	    <tr>
	      <th>Total promet</th>
	      <th class="text-center"><i class="fa fa-btn fa-hashtag" aria-hidden="true"></i></th>
	    </tr>
	  	</thead>
	  	<tbody>
	  	<tr>
	      <td>Ukupno faktura (kom)</td>
	      <td class="text-center">{{ $total->total }}&nbsp;kom</td>
	    </tr>
	   	<tr>
	      <td>Vrednost faktura (EUR)</td>
	      <td class="text-center">{{ number_format($total->total_euro, 2, ',', '.') }}&nbsp;&euro;</td>
	    </tr>
	   	<tr>
	      <td>Vrednost faktura (RSD)</td>
	      <td class="text-center">{{ number_format($total->total_din, 2, ',', '.') }}&nbsp;din</td>
	    </tr>
	  	<tr>
	      <td>PDV (RSD)</td>
	      <td class="text-center">{{ number_format($total->pdv_din, 2, ',', '.') }}&nbsp;din</td>
	    </tr>
	   	<tr>
	      <td>Vrednost faktura sa porezom (RSD)</td>
	      <td class="text-center">{{ number_format($total->total_din_tax, 2, ',', '.') }}&nbsp;din</td>
	    </tr>
  	</tbody>
</table>
@else
<div class="row text-center h4">
		U periodu od <br class="hidden-lg hidden-md hidden-sm"><span class="text-info">{{$formated_from}}</span> do <span class="text-info">{{$formated_to}}</span><br class="hidden-lg hidden-md hidden-sm"> nije bilo prometa.
</div>
@endif
<!-- /ajax total traffic -->