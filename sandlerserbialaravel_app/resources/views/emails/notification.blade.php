@extends('emails.email_template')

@section('title', 'Obaveštenje')

@section('content') 
<div class="container main-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">

                <div class="panel-heading san-yell">
                	<span class="glyphicon glyphicon-envelope"></span>&nbsp;Serbia Sandler
                  <h3 class="text-center">
                  	 <i>Obaveštenje</i>
                  </h3>
                </div>

                <div class="panel-body san-yell">

					<!-- Suspects-Today Meeting -->
                	@if($todays_meetings)
                	<div class="container-fluid well san-yell">
					    <h4><label><i>Danas:</i></label></h4>
					    <div class="h5">
					    @foreach($todays_meetings as $meeting)
							{{ $meeting['meeting_date'] }} zakazan sastanak sa: 
						    <a href="{{ url('/client/'.$meeting['client_id']) }}">
						    	<span class='text-info'>{{ $meeting['name'] }}</span>
						    </a><br><br>
                		@endforeach
                		</div>
					</div>
                	@endif
					<!-- /Suspects-Today Meeting -->
					<!-- Suspects-Tomorrow Meeting -->
                	@if($tomorrows_meetings)
                	<div class='container-fluid well san-yell'>
                		<h4><label><i>Sutra:</i></label></h4>
                		<div class="h5">
                		@foreach($tomorrows_meetings as $meeting)
							{{ $meeting['meeting_date'] }} zakazan sastanak sa: 
						    <a href="{{ url('/client/'.$meeting['client_id']) }}">
						    	<span class='text-info'>{{ $meeting['name'] }}</span>
						    </a><br><br>
                		@endforeach
                		</div>
                	</div>
                	@endif
                	<!-- /Suspects-Tomorrow Meeting -->
					<!-- Payments-Advance Tomorrow Issue -->
                	@if($payments_advance_issue_tomorrow)
			            @foreach($payments_advance_issue_tomorrow as $payment)
			            <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/payment/'.$payment->contract_id.'/'.$payment->payment_id) }}">
			              <span class='h5'>
			                Po Ugovoru br.{{$payment->contract_number}} od {{ date("d.m.Y.",strtotime($payment->contract_date)) }} sutra treba izdati profakturu u vrednosti od {{$payment->payment_value_euro}}&nbsp;&euro;
			              </span>
			            </a>
			            @endforeach
		            @endif
		            <!-- /Payments-Advance Tomorrow Issue -->
					<!-- Payments Tomorrow Issue -->
		            @if($payments_non_advance_issue_tomorrow)
			            @foreach($payments_non_advance_issue_tomorrow as $payment)
			            <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/payment/'.$payment->contract_id.'/'.$payment->payment_id) }}">
			              <span class='h5'>
			                Po Ugovoru br.{{$payment->contract_number}} od {{ date("d.m.Y.",strtotime($payment->contract_date)) }} sutra treba izdati fakturu u vrednosti od {{$payment->payment_value_euro}}&nbsp;&euro;
			              </span>
			            </a>
			            @endforeach
		            @endif
		            <!-- /Payments Tomorrow Issue -->
					<!-- Suspects-accept meeting status -->
					@if($accept > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home') }}">
				    	<span class='h5'>
				    		Potencijalni klijenti koji su prihvatili sastanak:&nbsp;&nbsp;
				    		<b class='text-warning'>{{$accept}}</b>
				    	</span>
				    </a>
					@endif
					<!-- /Suspects-accept meeting status -->
					<!-- Suspects-jpb status -->
					@if($jpb > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home') }}">
				    	<span class='h5'>
				    		Potencijalni klijenti - 'jasna precizna budućnost':&nbsp;&nbsp;
				    		<b class='text-warning'>{{$jpb}}</b>
				    	</span>
				    </a>
					@endif
					<!-- /Suspects-jpb status -->
					<!-- Contracts-unsigned status -->
					@if($unsigned > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home') }}">
				    	<span class='h5'>
				    		Ugovori koji se nalaze na čekanju za potpisivanje:&nbsp;&nbsp;
							<b class='text-warning'>{{$unsigned}}</b>
						</span>
					</a>
					@endif
					<!-- /Contracts-unsigned status -->
					<!-- Proinvoices-created for issuing -->
					@if($created_proinvoices > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home') }}">
				    	<span class='h5'>
				    		Profakture koje se nalaze na čekanju za izdavanje:&nbsp;&nbsp;
				    		<b class='text-warning'>{{$created_proinvoices}}</b>
				    	</span>
					</a>
					@endif
					<!-- Proinvoices-created for issuing -->
					<!-- Proinvoices-confirm paid -->
					@if($confirm_paid_proinvoices > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home') }}">
				    	<span class='h5'>
				    		Profakture koje se nalaze na čekanju za potvrdu da su plaćene:&nbsp;&nbsp;
				    		<b class='text-warning'>{{$confirm_paid_proinvoices}}</b>
				    	</span>
					</a>
					@endif
					<!-- Proinvoices-confirm paid -->
					<!-- Invoices-invoices from proinvoices -->
					@if($invoices_from_proinvoices > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home')}}">
				    	<span class='h5'>
				    		Fakture koje se nalaze na čekanju za izdavanje po plaćenim profakturama:&nbsp;&nbsp;
				    		<b class='text-warning'>{{$invoices_from_proinvoices}}</b>
				    	</span>
					</a>
					@endif
					<!-- Invoices-invoices from proinvoices -->
					<!-- Invoices-created for issuing -->
					@if($created_invoices > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home') }}">
				    	<span class='h5'>
				    		Fakture koje se nalaze na čekanju za izdavanje:&nbsp;&nbsp;
				    		<b class='text-warning'>{{$created_invoices}}</b>
				    	</span>
					</a>
					@endif
					<!-- Invoices-created for issuing -->
					<!-- Invoices-confirm paid -->
					@if($confirm_paid_invoices > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home') }}">
				    	<span class='h5'>
				    		Fakture koje se nalaze na čekanju za potvrdu da su plaćene:&nbsp;&nbsp;
				    		<b class='text-warning'>{{$confirm_paid_invoices}}</b>
				    	</span>
					</a>
					@endif
					<!-- Invoices-confirm paid -->
					<!-- Proinvoices-pay day -->
					@if($proinvoice_pay_date > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home') }}">
				    	<span class='h5'>
				    		Profakture koje se nalaze na čekanju za izdavanje na današnji dan:&nbsp;&nbsp;
				    		<b class='text-warning'>{{$proinvoice_pay_date}}</b>
				    	</span>
					</a>
					@endif
					<!-- Proinvoices-pay day -->
					<!-- Invoices-pay day -->
					@if($invoice_pay_date > 0)
				    <a class="btn btn-block btn-primary btn-text-left" href="{{ url('/home') }}">
				    	<span class='h5'>
				    		Fakture koje se nalaze na čekanju za izdavanje na današnji dan:&nbsp;&nbsp;
				    		<b class='text-warning'>{{$invoice_pay_date}}</b>
						</span>
					</a>
					@endif
					<!-- Invoices-pay day -->
					<br><br>
					<div>
						<h4 class='pull-right'>
						    <i><a class="text-info" href="{{ config('constants.application_url') }}">{{ config('constants.application_name') }}</a></i>
						</h4>
 					</div>

                </div><!-- panel-body  -->

            </div><!-- panel panel-default  -->
        </div>
    </div>
</div>
@endsection



