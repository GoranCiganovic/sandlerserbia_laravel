@extends('layouts.app')

@section('title', $client_status->global_name.' profil' )

@section('content')
<div class="main-container">
  <div class="container col-lg-10 col-lg-offset-1 col-md-12 col-sm-12">
    <div class="row">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-list" aria-hidden="true"></i>
          Profil - {{ $client_status->global_name }}
          <!-- Back Button -->
          <a href="{{url('/home')}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Početna</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3" id="confirm_name">
            {{ $individual->first_name." ".$individual->last_name }}     
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
        </div><!-- /panel-heading san-yell  -->

        <div class="panel-body san-yell">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right text-center">

              <!-- Client Status Accept Meeting -->
              @if($client_status->id == '3')
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-calendar " aria-hidden="true"></i>Datum sastanka
                </div>
                <form method="POST" id='form' class='form_prevent_multiple_submits' action='{{ url("individual/add_meeting_date/".$individual->id) }}'>
                  <!-- Datum sastanka  -->
                  <div class="form-group{{ $errors->has('format_meeting_date') ? ' has-error' : '' }}">
                    <input type="text" id="format_meeting_date" name="format_meeting_date" class="form-control" aria-describedby="format_meeting_dateHelp" value="{{ old('format_meeting_date') }}">
                    <input type="hidden" id="meeting_date" name="meeting_date" value="{{ old('meeting_date') }}">
                    @if ($errors->has('format_meeting_date'))
                    <small id="format_meeting_dateHelp" class="form-text text-danger h5">
                      {{ $errors->first('format_meeting_date') }}
                    </small>
                    @endif
                  </div>
                  <!-- /Datum sastanka  -->
                  <!-- /Token --> 
                  <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                  <!-- /Token -->
                  <!-- Button  -->
                  <button type="submit" id="submit" name="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                    <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>POTVRDI DATUM SASTANKA    
                  </button>
                  <!--/Button  -->
                </form>
              </div><!-- /panel panel-default san-light -->
              @endif
              <!-- /Client Status Accept Meeting -->

              <!-- Client Status Accept Meeting, JPB Or Disqualified -->
              @if($client_status->id != '5' and $client_status->id != '6') 
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-retweet" aria-hidden="true"></i>Promena statusa
                </div>
                <a href='{{ url("/client/change_status/".$individual->client_id."/3") }}' class='change_status panel-body-sm btn btn-default btn-block bg-success' role='button'>
                    <i class="fa fa-btn fa-handshake-o" aria-hidden="true"></i>
                    <span>PRIHVATIO SASTANAK</span>
                </a>
                <a href='{{ url("/client/change_status/".$individual->client_id."/4") }}' class='change_status panel-body-sm btn btn-default btn-block bg-info' role='button'>
                    <i class="fa fa-btn fa-thumbs-o-up" aria-hidden="true"></i>
                    <span>JASNA PRECIZNA BUDUĆNOST</span>
                </a>
                <a href='{{ url("/client/change_status/".$individual->client_id."/2") }}' class='change_status panel-body-sm btn btn-default btn-block bg-danger' role='button'>
                    <i class="fa fa-btn fa-ban" aria-hidden="true"></i>
                    <span>DISKVALIFIKOVAN</span>
                </a>
              </div><!-- /panel panel-default san-light -->
              @endif
              <!-- /Client Status Accept Meeting, JPB Or Disqualified -->

              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-edit " aria-hidden="true"></i>Izmena profila
                </div>
                <a href='{{ url("/client/edit/".$individual->client_id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-edit " aria-hidden="true"></i>
                    <span>IZMENI PROFIL</span>
                </a>
              </div><!-- /panel panel-default san-light -->

              @if($client_status->id == '1')  
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-times " aria-hidden="true"></i>Brisanje profila
                </div>
                <a href='{{ url("/client/delete/".$individual->client_id."/".$individual->client_status_id) }}' id="delete_profile" class='button_spinner panel-body-sm btn btn-danger btn-block' role='button'>
                    <i class="no_spinner fa fa-btn fa-times " aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>
                    <span>OBRIŠI PROFIL</span>
                </a>
              </div><!-- /panel panel-default san-light -->
              @endif

              @if($client_status->id == '5' || $client_status->id == '6' || $client_status->id == '3') 
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-briefcase " aria-hidden="true"></i>Ugovori
                </div>
                <a href='{{ url("/contract/create/".$clientID) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-folder-open " aria-hidden="true"></i>
                    <span>NOVI UGOVOR</span>
                </a>
                @if(count($contracts) > 0)
                  @foreach($contracts as $contract)
                    <a href='{{ url("/contract/".$contract->id) }}' class='panel-body-sm btn btn-{{ $contract->contract_status->color }} btn-block' role='button'>
                        <i class="fa fa-btn {{ $contract->contract_status->icon }} " aria-hidden="true"></i>
                        <span>
                          @if($contract->contract_status_id == '1')
                            NEDOGOVOREN
                          @else
                            {{ mb_strtoupper($contract->contract_status->name) }}
                          @endif
                            BR. {{ $contract->contract_number }} od {{ date("d.m.Y.",strtotime($contract->contract_date)) }}
                        </span>
                    </a>
                  @endforeach
                @endif
              </div><!-- /panel panel-default san-light -->

              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-files-o" aria-hidden="true"></i>Prezentacije/Treninzi
                </div>
                <a href='{{ url("/presentation/create/".$clientID."/proinvoice") }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-edit" aria-hidden="true"></i>
                    <span>NOVA PROFAKTURA</span>
                </a>
                <a href='{{ url("/presentation/create/".$clientID."/invoice") }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-edit" aria-hidden="true"></i>
                    <span>NOVA FAKTURA</span>
                </a>
                <!-- Proinvoices -->
                @if(count($proinvoices) > 0)

                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-files-o" aria-hidden="true"></i>Profakture
                </div>
                  @foreach($proinvoices as $proinvoice)
                  
                    <!-- Proinvoice Is Not Issued -->
                    @if($proinvoice->is_issued == '0')
                      <a href='{{ url("/presentation/edit/".$clientID."/proinvoice/".$proinvoice->id) }}' class='panel-body-sm btn btn-default btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                          <span>IZMENI PROFAKTURU {{$proinvoice->proinvoice_number}}</span>
                      </a>
                    @endif
                    <!-- /Proinvoice Is Not Issued --> 
                    <!-- Proinvoice Is Issued and Not Paid --> 
                    @if($proinvoice->is_issued == '1' and $proinvoice->is_paid == '0')
                      <a href='{{ url("/presentation/show/".$clientID."/proinvoice/".$proinvoice->id) }}' class='panel-body-sm btn btn-info btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                          <span>IZDATA PROFAKTURA {{$proinvoice->proinvoice_number}}</span>
                      </a>
                    @endif
                    <!-- /Proinvoice Is Issued and Not Paid --> 
                    <!-- Proinvoice Is Paid-->
                    @if($proinvoice->is_paid == '1')
                      <a href='{{ url("/presentation/show/".$clientID."/proinvoice/".$proinvoice->id) }}' class='panel-body-sm btn btn-success btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text" aria-hidden="true"></i>
                          <span>PLAĆENA PROFAKTURA {{$proinvoice->proinvoice_number}}</span>
                      </a>
                      <!-- Invoice Is Not Issued  -->
                      @if(!$proinvoice->invoice_number)
                        <a href='{{ url("/presentation/create_from_proinvoice/".$clientID."/".$proinvoice->proinvoice_id) }}' class='panel-body-sm btn btn-info btn-block' role='button'>
                            <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                            <span>NAPRAVI FAKTURU PROFAKTURE {{$proinvoice->proinvoice_number}}</span>
                        </a>
                      <!-- /Invoice Is Not Issued  -->
                      @else
                      <!-- Invoice Is Issued  -->
                      <a href='{{ url("/presentation/show/".$clientID."/invoice/".$proinvoice->invoice_id) }}' class='panel-body-sm btn btn-success btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text" aria-hidden="true"></i>
                          <span>FAKTURA {{$proinvoice->invoice_number}} PLAĆENE PROFAKTURE {{$proinvoice->proinvoice_number}}</span>
                      </a>
                      @endif
                      <!-- /Invoice Is Issued  -->
                    @endif
                    <!-- /Proinvoice Is Paid --> 

                  @endforeach
                @endif
                <!-- /Proinvoices -->

                <!-- Invoices -->
                @if(count($invoices) > 0)
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-files-o" aria-hidden="true"></i>Fakture
                </div>
                  @foreach($invoices as $invoice)
                    <!-- Invoice Is Not Issued -->
                    @if($invoice->is_issued == '0' and $invoice->proinvoice_id == '')
                      <a href='{{ url("/presentation/edit/".$clientID."/invoice/".$invoice->id) }}' class='panel-body-sm btn btn-default btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                          <span>IZMENI FAKTURU {{$invoice->invoice_number}}</span>
                      </a>
                    @endif
                    <!-- /Invoice Is Not Issued --> 
                    <!-- Invoice Is Issued --> 
                    @if($invoice->is_issued == '1' and $invoice->is_paid == '0')
                      <a href='{{ url("/presentation/show/".$clientID."/invoice/".$invoice->id) }}' class='panel-body-sm btn btn-info btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                          <span>IZDATA FAKTURA {{$invoice->invoice_number}}</span>
                      </a>
                    @endif
                    <!-- /Invoice Is Issued  --> 
                    <!-- Invoice Is Paid --> 
                    @if($invoice->is_issued == '1' and $invoice->is_paid == '1')
                      <a href='{{ url("/presentation/show/".$clientID."/invoice/".$invoice->id) }}' class='panel-body-sm btn btn-success btn-block' role='button'>
                          <i class="fa fa-btn fa-file-text" aria-hidden="true"></i>
                          <span>PLAĆENA FAKTURA {{$invoice->invoice_number}}</span>
                      </a>
                    @endif
                    <!-- /Invoice Is Paid  --> 
                  @endforeach
                @endif

              </div><!-- /panel panel-default san-light -->
              @endif

            </div><!-- /col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right text-center -->

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pull-left text-left">

                  <!-- Table -->
                  <table class="table table-hover">

                      <thead>
                        <!-- Status  -->
                        <tr>
                          <th class='col-sm-5 col-md-4'>
                            <i class="fa fa-btn {{ $client_status->local_icon }}"></i>Status:
                          </th>
                          <th class="text-center">
                              <span class="h5 {{$client_status->text_color}}">
                                <b><i>{{$client_status->local_name}}</i></b>
                              </span>
                          </th>
                        </tr>
                        <!-- /Status  -->
                      </thead>

                      <tbody>

                        <!-- Datum statusa (Prihvaio Sastanak, JPB ili Diskvalifikovan) -->
                        @if($individual->conversation_date and $client_status->id != '6' and $client_status->id != '5' )
                        <tr>
                          <td><i class="fa fa-btn fa-calendar"></i>Datum statusa:</td>
                          <td class="text-center">
                            <span>{{ date('d.m.Y.', strtotime($individual->conversation_date)) }}</span>
                          </td>
                        </tr>
                        @endif
                        <!-- /Datum statusa (Prihvaio Sastanak, JPB ili Diskvalifikovan) -->

                        <!-- Prihvatio sastanak  -->
                        @if($individual->accept_meeting_date)
                        <tr>
                          <td><i class="fa fa-btn fa-calendar"></i>Prihvatio sastanak:</td>
                          <td class="text-center">
                            <span>{{ date('d.m.Y.', strtotime($individual->accept_meeting_date)) }}</span>
                          </td>
                        </tr>
                        @endif
                        <!-- /Prihvatio sastanak -->

                        <!-- Datum sastanka  -->
                        @if($individual->meeting_date)
                        <tr>
                          <td><i class="fa fa-btn fa-calendar"></i>Datum sastanka:</td>
                          <td class="text-center">
                            <span>{{ date('d.m.Y. - H:i', strtotime($individual->meeting_date)) }}h</span>
                          </td>
                        </tr>
                        @endif
                        <!-- /Datum sastanka  -->

                        <!-- Postao klijent -->
                        @if($individual->closing_date)
                        <tr>
                          <td><i class="fa fa-btn fa-calendar"></i>Postao klijent:</td>
                          <td class="text-center">
                            <span>{{ date('d.m.Y.', strtotime($individual->closing_date)) }}</span>
                          </td>
                        </tr>
                        @endif
                        <!-- /Postao klijent  -->

                        <!-- Pravni status  -->
                        <tr>
                          <td><i class="fa fa-btn fa-building"></i>Pravni status:</td>
                          <td class="text-center">
                           <span>Fizičko lice</span>
                          </td>
                        </tr>
                        <!-- /Pravni status  -->

                        <!-- Telefon  -->
                        <tr>
                          <td><i class="fa fa-btn fa-phone"></i>Telefon:</td>
                          <td class="text-center">
                            <span>{{$individual->phone}}</span>
                          </td>
                        </tr>
                        <!-- /Telefon  -->

                        <!-- Email adresa  -->
                        <tr>
                          <td><i class="fa fa-btn fa-at"></i>Email adresa:</td>
                          <td class="text-center">
                            <span>{{$individual->email}}</span>
                          </td>
                        </tr>
                        <!-- /Email adresa -->

                        <!-- Zaposlen u  -->
                        <tr>
                          <td><i class="fa fa-btn fa-building"></i>Zaposlen u:</td>
                          <td class="text-center">
                            <span>{{$individual->works_at}}</span>
                          </td>
                        </tr>
                        <!-- /Zaposlen u  -->

                        <!-- Adresa  -->
                        <tr>
                          <td><i class="fa fa-btn fa-map-marker"></i>&nbsp;&nbsp;Adresa:</td>
                          <td class="text-center">
                            <span>{{$individual->address}}</span>
                          </td>
                        </tr>
                        <!-- /Adresa  -->

                        <!-- Opština  -->
                        <tr>
                          <td><i class="fa fa-btn fa-map-marker"></i>&nbsp;&nbsp;Opština:</td>
                          <td class="text-center">
                            <span>{{$individual->county}}</span>
                          </td>
                        </tr>
                        <!-- /Opština  -->

                        <!-- Grad  -->
                        <tr>
                          <td><i class="fa fa-btn fa-map-marker"></i>&nbsp;&nbsp;Grad:</td>
                          <td class="text-center">
                            <span>{{$individual->city}}</span>
                          </td>
                        </tr>
                        <!-- /Grad  -->

                        <!-- Komentar -->
                        <tr>
                          <td><i class="fa fa-btn fa-comment-o"></i>Komentar:</td>
                          <td class="text-center">
                            <span>{{$individual->comment}}</span>
                          </td>
                        </tr>
                        <!-- /Komentar  -->
                                  
                      </tbody>

                  </table>
                  <!-- /Table -->
              
            </div><!-- /col-lg-8 col-md-8 col-sm-8 col-xs-12 pull-left text-left -->
          </div><!-- /row -->
        </div><!-- /panel-body  -->

      </div><!-- /panel panel-default  -->

    </div><!-- /row -->
  </div><!-- /container col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 -->
</div><!-- /main-container -->
<div class="container"></div>
@endsection

@section('script')
<script src="/js/clients/profile_confirm.js"></script>
<script src="/js/clients/meeting_date.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection