@extends('layouts.app')

@section('title', 'Ugovor br.'.$contract->contract_number)

@section('content')
<div class="main-container">
  <div class="container col-lg-10 col-lg-offset-1 col-md-12 col-sm-12">
    <div class="row">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">
          <i class="fa fa-btn fa-list" aria-hidden="true"></i>Ugovor
          <!-- Back Button -->
          <a href="{{ url('/client/'.$client->client_id)}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Profil</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-folder-o" aria-hidden="true"></i> 
            <span id="confirm_name">{{ ($contract->legal_status_id == '1') ? 'Ugovor br. '.$contract->contract_number  : ' Neformalan Ugovor' }}</span>
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
        </div>
 
        <div class="panel-body san-yell">
          <div class="row">

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pull-left text-left">

                  <!-- Table -->
                  <table class="table table-hover">

                      <thead>
                        <!-- Status  -->
                        <tr>
                          <th class='col-xs-5 col-sm-4 col-md-3'>
                            <i class="fa fa-btn {{ $contract_status->icon }}"></i>Status:
                          </th>
                          <th class="text-center">
                            <span class="h5 text-{{ $contract_status->color }}">
                              <b><i>
                              @if($contract->legal_status_id == '2')
                                {{ ($contract_status->id == '1') ? 'Nedogovoren' :  $contract_status->name }}
                              @else
                                {{ $contract_status->name }}
                              @endif
                              </i></b>
                            </span>
                          </th>
                        </tr>
                        <!-- /Status  -->
                      </thead>

                      <tbody>

                        <!-- Klijent -->
                        <tr>
                          <td><i class="fa fa-btn fa-star"></i>Klijent:</td>
                          <td class="text-center">
                            <span>{{$client->long_name.$client->first_name." ".$client->last_name}}</span>
                          </td>
                        </tr>
                        <!-- /Klijent -->

                        <!-- Broj Ugovora -->
                        <tr>
                          <td><i class="fa fa-btn fa-hashtag"></i>Broj Ugovora:</td>
                          <td class="text-center">
                            <span>{{$contract->contract_number}}</span>
                          </td>
                        </tr>
                        <!-- /Broj Ugovora -->                

                        <!-- Datum Ugovora -->
                        <tr>
                          <td><i class="fa fa-btn fa-calendar"></i>Datum Ugovora:</td>
                          <td class="text-center">
                            <span>{{ date("d.m.Y.",strtotime($contract->contract_date)) }}</span>
                          </td>
                        </tr>
                        <!-- /Datum Ugovora -->

                        <!-- /Vrednost Ugovora -->
                        <tr>
                          <td>&nbsp;<i class="fa fa-btn fa-eur"></i>&nbsp;Vrednost Ugovora:</td>
                          <td class="text-center">
                            <span>{{ number_format($contract->value,2,",",".") }} &euro;</span>
                          </td>
                        </tr>
                        <!-- /Vrednost Ugovora -->

                        <!-- /Avans -->
                        <tr>
                          <td>&nbsp;<i class="fa fa-btn fa-eur"></i>&nbsp;Avans:</td>
                          <td class="text-center">
                           <span>{{ number_format($contract->advance,2,",",".") }} &euro;</span>
                          </td>
                        </tr>
                        <!-- /Avans -->

                        <!-- Broj rata -->
                        <tr>
                          <td><i class="fa fa-btn fa-calendar-check-o"></i>Broj rata:</td>
                          <td class="text-center">
                            <span>{{$contract->payments}}</span>
                          </td>
                        </tr>
                        <!-- /Broj rata -->

                        <!-- Broj ucesnika -->
                        <tr>
                          <td><i class="fa fa-btn fa-user-times"></i>Broj učesnika:</td>
                          <td class="text-center">
                            <span>{{$contract->participants}}</span>
                          </td>
                        </tr>
                        <!-- /Broj ucesnika -->

                        <!-- Uplaćeno -->
                        <tr>
                          <td>&nbsp;<i class="fa fa-btn fa-eur"></i>&nbsp;Uplaćeno:</td>
                          <td class="text-center">
                            <span>{{ number_format($contract->paid,2,",",".") }} &euro;</span>
                          </td>
                        </tr>
                        <!-- /Uplaćeno -->

                        <!-- Ostatak za uplatu -->
                        <tr>
                          <td>&nbsp;<i class="fa fa-btn fa-eur"></i>&nbsp;Ostatak za uplatu:</td>
                          <td class="text-center">
                            <span>{{ number_format($contract->rest,2,",",".") }} &euro;</span>
                          </td>
                        </tr>
                        <!-- /Ostatak za uplatu -->

                        <!-- Datum početka -->
                        <tr>
                          <td><i class="fa fa-btn fa-calendar"></i>Datum početka:</td>
                          <td class="text-center">
                            <span>
                              @if($contract->start_date)
                                {{ date("d.m.Y.",strtotime($contract->start_date)) }}
                              @endif
                            </span>
                          </td>
                        </tr>
                        <!-- /Datum početka -->

                        <!-- Datum završetka -->
                        <tr>
                          <td><i class="fa fa-btn fa-calendar"></i>Datum završetka:</td>
                          <td class="text-center">
                            <span>
                              @if($contract->end_date)
                                {{ date("d.m.Y.",strtotime($contract->end_date)) }}
                              @endif
                            </span>
                          </td>
                        </tr>
                        <!-- /Datum završetka -->

                        <!-- Mesto odrzavanja -->
                        <tr>
                          <td>&nbsp;<i class="fa fa-btn fa-map-marker"></i>&nbsp;Mesto održavanja:</td>
                          <td class="text-center">
                            <span>{{$contract->event_place}}</span>
                          </td>
                        </tr>
                        <!-- /Mesto odrzavanja -->

                        <!-- Vreme odrzavanja -->
                        <tr>
                          <td><i class="fa fa-btn fa-clock-o "></i>Vreme održavanja:</td>
                          <td class="text-center">
                            <span>{{$contract->event_time}}</span>
                          </td>
                        </tr>
                        <!-- /Vreme odrzavanja -->

                        <!-- Broj casova -->
                        <tr>
                          <td><i class="fa fa-btn fa-pencil"></i>Broj časova:</td>
                          <td class="text-center">
                            <span>{{$contract->classes_number}}</span>
                          </td>
                        </tr>
                        <!-- /Broj casova  -->

                        <!-- Dinamika rada -->
                        <tr>
                          <td><i class="fa fa-btn fa-pencil"></i>Dinamika rada:</td>
                          <td class="text-center">
                            <span>{{$contract->work_dynamics}}</span>
                          </td>
                        </tr>
                        <!-- /Dinamika rada  -->

                        <!-- Opis Ugovora -->
                        <tr>
                          <td><i class="fa fa-btn fa-pencil"></i>Opis Ugovora:</td>
                          <td class="text-center">
                            <span>{{$contract->description}}</span>
                          </td>
                        </tr>
                        <!-- /Opis Ugovora -->
                                  
                      </tbody>

                  </table>
                  <!-- /Table -->

            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right text-center">

             
              <!-- PDF UGOVOR -->
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-file-pdf-o" aria-hidden="true"></i>Ugovor u PDF formatu
                </div>
                @if($contract_status->id == '1')
                <a href='{{ url("/pdf/contract_default/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-file-pdf-o" aria-hidden="true"></i>
                    <span>DEFAULT UGOVOR PDF</span>
                </a>
                <a href='{{ url("/contract/custom/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-edit" aria-hidden="true"></i>
                    <span>EDITOR UGOVORA</span>
                </a>
                @else
                <a href='{{ url("/pdf/contract_signed/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-file-pdf-o" aria-hidden="true"></i>
                    <span>UGOVOR PDF</span>
                </a>
                @endif
              </div>
              <!-- /PDF UGOVOR -->

              <!-- FAKTURE -->
              @if($contract_status->id != '1')
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>Rate/Fakture
                </div>
                <a href='{{ url("/payments/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-file-text-o" aria-hidden="true"></i>
                    <span>RATE/FAKTURE</span>
                </a>
              </div>
              @endif
              <!-- /FAKTURE -->

              <!-- UČESNICI -->
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-users" aria-hidden="true"></i>Učesnici
                </div>
                <a href='{{ url("/participants/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-users" aria-hidden="true"></i>
                    <span>UČESNICI</span>
                </a>
              </div>
              <!-- /UČESNICI -->

              <!-- OPIS UGOVORA -->
              @if($contract_status->id == '2')
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-comment-o " aria-hidden="true"></i>Izmena opisa Ugovora
                </div>
                <a href='{{ url("/contract/add_description/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-edit " aria-hidden="true"></i>
                    <span>IZMENI OPIS UGOVORA </span>
                </a>
              </div>
              @endif
              <!-- /OPIS UGOVORA -->

               <!-- AKO JE UGOVOR U TOKU -->
              @if($contract_status->id == '2')
              <!-- RASKINI UGOVOR -->
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-ban " aria-hidden="true"></i>Raskidanje Ugovora
                </div>
                <a href='{{ url("/contract/break_up/".$contract->id) }}' id="break_up_contract" class='panel-body-sm btn btn-danger btn-block' role='button'>
                    <i class="no_spinner fa fa-btn fa-ban " aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>
                    <span>RASKINI UGOVOR</span>
                </a>
              </div>
              <!-- /RASKINI UGOVOR -->
              @endif
              <!-- /AKO JE UGOVOR U TOKU -->

              <!-- AKO UGOVOR NIJE POTPISAN -->
              @if($contract_status->id == '1')
              <!-- RATE -->
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>Rate
                </div>
                <a href='{{ url("/payments/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>
                    <span>RATE</span>
                </a>
              </div>
              <!-- /RATE -->
              <!-- POTPISAN UGOVOR -->
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-pencil" aria-hidden="true"></i>
                      @if($contract->legal_status_id == '2')
                        Potvrda dogovora
                      @else
                        Potvrda potpisa
                      @endif
                </div>
                <a href='{{ url("/contract/sign/".$contract->id) }}' id="signed_contract" class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="no_spinner fa fa-btn fa-check-square-o" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>
                    <span id='contract_status'>
                      @if($contract->legal_status_id == '2') DOGOVOREN @else POTPISAN @endif
                    </span>
                    <span>UGOVOR</span>
                </a>
              </div>
              <!-- /POTPISAN UGOVOR -->
              <!-- IZMENI UGOVOR -->
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-edit " aria-hidden="true"></i>Izmena Ugovora
                </div>
                <a href='{{ url("/contract/edit/".$contract->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-edit " aria-hidden="true"></i>
                    <span>IZMENI UGOVOR</span>
                </a>
              </div>
              <!-- /IZMENI UGOVOR -->
              <!-- OBRIŠI UGOVOR -->
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-times " aria-hidden="true"></i>Brisanje Ugovora
                </div>
                <a href='{{ url("/contract/delete/".$contract->id) }}' id="delete_contract" class=' panel-body-sm btn btn-danger btn-block' role='button'>
                    <i class="no_spinner fa fa-btn fa-times" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>
                    <span>OBRIŠI UGOVOR</span> 
                </a>
              </div>
              <!-- /OBRIŠI UGOVOR -->
              @endif
              <!-- /AKO UGOVOR NIJE POTPISAN -->

            </div>

          </div>
        </div>

      </div>

    </div>
  </div> 
</div>
<div class="container"></div>
@endsection

@section('script')
<script src="/js/contracts/contract_confirm.js"></script>
@endsection

