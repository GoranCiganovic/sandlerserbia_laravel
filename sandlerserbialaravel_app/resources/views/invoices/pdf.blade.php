<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Meta Tags -->
        @include('layouts.head.meta') 
        <!-- Title -->
        <title>{{ $payment['type'] }}</title>
        <!-- Bootstrap CDN Styles -->
        @include('layouts.head.style_bootstrap') 
		<!-- Styles Custom -->
		<style type="text/css">

			body{
				font-family:'helvetica';
				font-size:16px;
			}
			.wrapper{
				border:1px solid #888;
				height:1200px;
				padding:50px 20px 0; 
			}
			.header{
				border:1px solid #000;
				height:450px;
		
			}
			.san-blue{
				background-color:#005DAB;
				color: #fff;
			}
			.san-yell{
				background-color:#E9AA00;
				color: #000;
			}
			tbody, td{
				border-bottom:1.5px solid #666;
				border-right:1px solid #999;
				border-left:1px solid #999;
			}
			.certificate{
				position:fixed;
				left:320px;
				top:1120px;

			}
			.signature{
				position:fixed;
				left:40px;
				top:1020px;
			}
			footer{
				font-size:14px;
				text-align:center;
				position: fixed;
				left:70px;
				top:1210px;
			}

		</style>
    </head>
	<body>
		<div class="wrapper">
			<div class="row">
					<div class="col-xs-12">
						<div class="well header col-xs-5">
							<p>Davalac usluge:</p>
							<label>{{$gt['name']}}</label>
							<p>Adresa: {{$gt['address']}}, {{$gt['postal']}} {{$gt['county']}}</p>
							<p>Matični broj: {{$gt['identification']}}</p>
							<p>PIB: {{$gt['pib']}}</p>
							<p>Banka: {{$gt['bank']}}</p>
							<p>Račun: {{$gt['account']}}</p>
							<p>{{ $payment['number']}} </p>
							<p>Mesto i datum izdavanja računa: Beograd,  {{ date("d.m.Y.",strtotime($payment['issue_date'])) }}</p>
							<p>Datum prometa dobara i usluga:dff {{ date("d.m.Y.",strtotime($payment['traffic_date'])) }}</p>
						</div>
						<div class="col-xs-2 text-center">
							<img class="img-responsive" src="{{ asset('/storage/images/sandler/sandler_logo.gif')}}" alt="Sandler Logo">
						</div>
						<div class="well header col-xs-5">
							<p>Primalac usluge:</p>
							<label>{{$client['name']}}</label>
							<p>Adresa: {{$client['address']}}, {{$client['postal']}} {{$client['city']}}</p>
							<p>{{$client['id_number']}}: {{$client['identification']}}</p>
							<p>{{$client['personal_number']}}: {{$client['pib']}}</p>

						</div>
					</div>
			</div>
			<table class="table">
			    <thead class='san-blue'>
			      <tr>
			        <th class='panel-heading' colspan="3">Opis usluge: {{$payment['description']}}</th>
			      </tr>
			    </thead>
			    <tbody>
			      <tr>
			        <td>Poreska osnovica {{ number_format($payment['pdv'], 2, ',', '.') }}%</td>
			        <td>{{ number_format($payment['value_din'], 2, ',', '.') }}</td>
			      </tr>
			      <tr>
			        <td>Opšta stopa PDV-a {{ number_format($payment['pdv'], 2, ',', '.') }}%</td>
			        <td>{{ number_format($payment['pdv'], 2, ',', '.') }}</td>
			      </tr>
			      <tr>
			        <td>Ukupno PDV-a</td>
			        <td>{{ number_format($payment['pdv_din'], 2, ',', '.') }}</td>
			      </tr>
			      <tr>
			        <td>Ukupno sa PDV-om total</td>
			        <td>{{ number_format($payment['value_din_tax'], 2, ',', '.') }}</td>
			      </tr> 
			    </tbody>
			</table>
			  
		  	<div class="panel san-blue">
			  	<div class="panel-heading text-center">
			  	Obračunat srednji kurs NBS u iznosu: {{ number_format($payment['exchange_euro'], 4, ',', '.') }} din za evro, na dan {{ date("d.m.Y.",strtotime($payment['issue_date'])) }} godine
			  	</div>
		  	</div>
		
			<div class="panel san-yell">
				<div class="panel-heading text-center">
				  	Uplatu možete izvršiti na račun: {{$gt['account']}}, {{$gt['bank']}}
				</div>
			</div>

			<div>Napomena o poreskom oslobađanju: {{$payment['note']}}</div>
			 
			<div class="row">
				<div class="col-xs-12">
					<div class="signature col-xs-4 text-center">	
						Global Training doo je ovlašćeni zastupnik za Srbiju kompanije Sandler Systems ltd
						<img class="img-responsive" src="{{ asset('/storage/images/sandler/sandler_black_logo.png')}}" alt="Sandler Logo">
					</div>
					<div class="certificate col-xs-7">
						<div class="row">
							<div class="col-xs-12">
								<div class="col-xs-3">
									<img class="img-responsive" src="{{ asset('/storage/images/sandler/certified1.png')}}" alt="Sandler Logo">
								</div>
								<div class="col-xs-3">
									<img class="img-responsive" src="{{ asset('/storage/images/sandler/certified2.jpg')}}" alt="Sandler Logo">
								</div>
								<div class="col-xs-3">
									<img class="img-responsive" src="{{ asset('/storage/images/sandler/certified3.png')}}" alt="Sandler Logo">
								</div>
								<div class="col-xs-3">
									<img class="img-responsive" src="{{ asset('/storage/images/sandler/certified4.png')}}" alt="Sandler Logo">
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		
		</div>
		<footer>
			naziv: {{$gt['name']}}, sedište: {{$gt['address']}}, {{$gt['postal']}} {{$gt['county']}}<br>
			banka: {{$gt['bank']}}, račun: {{$gt['account']}}, PIB: {{$gt['pib']}}, matični broj: {{$gt['identification']}}<br>
			kontakt: {{$gt['phone']}}, email: {{$gt['email']}}, website: {{$gt['website']}}<br>
		</footer>
	</body>
</html>
